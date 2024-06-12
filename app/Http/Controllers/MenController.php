<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mens;

class MenController extends Controller
{
    public function adminmens()
    {
        $mens = mens::all();
        return view('mens.adminmens',compact('mens'));
    }

    public function createmens(){
        return view('mens.createmens');
    }
    
    
        public function storemens(Request $request){
            //validate data
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:1000'
                ], [
                        'name.required' => '**The name field is required.',
                        'description.required' => '**The description field is required.',
                        'price.required' => '**The price filed is required.',
                        'image.required' => '**The image field is required.',
                ]);
                
                //upload image
                $imageName = time().'.'.$request->image->extension();
               
            $request->image->move(public_path('img'),$imageName);
    
            $men = new mens;
            $men->image = $imageName;
            $men->name = $request->name;
            $men->description = $request->description;
            $men->price = $request->price ?? 0;
    
            $men->save();
             return redirect()->route('adminmens')->withSuccess('men Created');
        }

        public function editmens($id){
            //dd($id);
            $men = mens::where('id',$id)->first();
            return view('mens.editmens',['men'=>$men]);
        }
     
        public function updatemens(Request $request, $id){
          //dd($request->all());
           $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1000'
            ], [
                    'name.required' => '**The name field is required.',
                    'description.required' => '**The description field is required.',
                    'price.required' => '**The price filed is required.',
                    // 'image.required' => '**The image field is required.',
            ]);
            
            $men = Mens::where('id',$id)->first();
    
            if(isset($request->image)){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('img'),$imageName);
                $men->image = $imageName;
            }
                    
       
        $men->name = $request->name;
        $men->description = $request->description;
        $men->price = $request->price;
       
            
        $men->save();
        return redirect()->route('adminmens')->withSuccess('product Updated');
    
        }
    
        public function deletemens($id){
            $men = mens::findOrFail($id);

            // Delete the image file if it exists
            $imagePath = public_path('img') . '/' . $men->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $men->delete();
            return back()->withSuccess('men Deleted');
        }

        public function mens(){
            $mens = Mens::all();
            return view('mens.men',compact('mens'));
        }
}
