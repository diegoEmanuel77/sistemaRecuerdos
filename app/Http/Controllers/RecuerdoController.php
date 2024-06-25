<?php
namespace App\Http\Controllers;

use App\Models\Recuerdo;
use App\Models\Imagen;
use App\Models\Mensaje;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
class RecuerdoController extends Controller
{
    public function index()
    {
        $recuerdos = Recuerdo::all();
        return view('recuerdos.index', compact('recuerdos'));
    }

    public function create()
    {
        return view('recuerdos.create');
    }

    public function storeMensaje(Request $request)
    {
 
        $mensaje = Mensaje::create([
           
        'recuerdo_id'=>  $request['idr'],
        'nombre'=>  $request['nombre'],
        'mensaje'=>  $request['mensaje'],
        'imagen'=>  $imagenPath = $request->file('imagen') ? $request->file('imagen')->store('imagenes', 'public') : null,
           
        ]);
        return redirect()->back()->with('success', 'Recuerdo creado correctamente.');
    }

    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'user_id' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'portada' => 'required|image',
            'audio' => 'nullable|file|mimes:audio/mpeg,mpga,mp3,wav', 
            'imagenes.*' => 'nullable|image', 
        ]);

        // Procesar y almacenar datos (ejemplo básico)
        $recuerdo = new Recuerdo();
        $recuerdo->user_id =$validatedData['user_id'];     
        $recuerdo->nombre = $validatedData['nombre'];
        $recuerdo->descripcion = $validatedData['descripcion'];
        $recuerdo->portada = $request->file('portada')->store('portadas', 'public');

        if ($request->hasFile('audio')) {
            $recuerdo->audio = $request->file('audio')->store('audios', 'public');
        }

        $recuerdo->save();

        // Procesar imágenes adicionales si se subieron
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $rutaImagen = $imagen->store('imagenes', 'public');
                $imagen = Imagen::create([
                    'recuerdo_id'=> $recuerdo->id,
                    'url'=>$rutaImagen,
                   
                ]);
               
                
            }
        }

        
        return redirect()->back()->with('success', 'Recuerdo creado correctamente.');
    }

   public function visita($idr)
   {

    $idr =Crypt::decrypt($idr);
    $recuerdos = Recuerdo::where('id',$idr)
    ->with('imagenes')
    ->with('mensajes')
    ->first();


    
   

    
    return view('users.visita',compact('recuerdos'));
   }

   public function generaQr($idr)
   {
    
    $qrCode = QrCode::size(300)->generate('http://192.168.1.108./sistemaRecuerdos/public/visita/'.$idr);
    // Limpia el buffer de salida
         // Configura los encabezados de respuesta para la descarga del archivo
         $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename=qrcode.png',
        ];

        // Limpia el buffer de salida
        ob_clean();
        flush();

        // Devuelve la respuesta con el código QR como archivo descargable
        return Response::make($qrCode, 200, $headers);
            
   }
   public function edit($id)
    {
        $recuerdo = Recuerdo::with('mensajes', 'imagenes')->findOrFail($id);
        $imagenes = $recuerdo->imagenes()->paginate(5); // Paginar las imágenes
        $img = Imagen::where('recuerdo_id',$id)->count();
        
        return view('recuerdos.edit', compact('recuerdo','img','imagenes'));
    }
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'portada' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|mimes:mp3,wav|max:5000',
        ]);

        $recuerdo = Recuerdo::findOrFail($id);

        // Eliminar archivo de portada antiguo
        if ($request->hasFile('portada')) {
            $portadaPath = str_replace('storage', 'public', $recuerdo->portada);
            Storage::delete($portadaPath);
         
        }

        // Eliminar archivo de audio antiguo
        if ($request->hasFile('audio')) {
            if ($recuerdo->audio) {
                $audioPath = str_replace('storage', 'public', $recuerdo->audio);
                Storage::delete($audioPath);
            }
            
        }

        $recuerdo->nombre = $request->nombre;
        $recuerdo->descripcion = $request->descripcion;
        $recuerdo->save();


          
            if ($request->has('eliminar_imagenes')) {
                foreach ($request->eliminar_imagenes as $imagenId) {
                    $imagen = Imagen::findOrFail($imagenId);
                   
                    $imagePath = str_replace('storage', 'public', $imagen->url);
                 
                    Storage::delete($imagePath);
                    
                    $imagen->delete();
                }
            }

            // Guardar nuevas imágenes
            if ($request->hasFile('imagenes')) {
                foreach ($request->file('imagenes') as $file) {
                    $path = $file->store('imagenes', 'public');
                  
                    $imagen = new Imagen();
                    $imagen->recuerdo_id = $recuerdo->id;
                    $imagen->url = $path;
                    $imagen->save();
                }
            }
            
        if ($request->has('eliminar_mensaje')) {
            foreach ($request->eliminar_mensaje as $mensajeId) {
                $mensaje = Mensaje::findOrFail($mensajeId);
               
                if ($mensaje->imagen) {

                    $mensajeimagen = str_replace('storage', 'public', $mensaje->imagen);
                    Storage::delete($mensajeimagen);    
                }
                $mensaje->delete();
            }
        }
        return redirect()->back()->with('success', 'Recuerdo actualizado exitosamente');
    }

    public function destroy($id)
    {
        $recuerdo = Recuerdo::findOrFail($id);
        $recuerdo->delete();

        return redirect()->route('recuerdos.index')->with('success', 'Recuerdo deleted successfully');
    }
}
