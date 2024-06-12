<?php

namespace App\Http\Controllers;
use App\Models\Electronics; 

use Illuminate\Http\Request;

class ElectronicsController extends Controller
{
    public function adminElectronics()
    {
        $electronicss = Electronics::all();
        return view('electronics.adminElectronics',compact('electronicss'));
    }

    public function createElectronics(){
        return view('electronics.createElectronics');
    }
    
    
        public function storeElectronics(Request $request){
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
    
            $electronics = new electronics;
            $electronics->image = $imageName;
            $electronics->name = $request->name;
            $electronics->description = $request->description;
            $electronics->price = $request->price ?? 0;
    
            $electronics->save();
             return redirect()->route('adminElectronics')->withSuccess('electronics Created');
        }
        public function editElectronics($id){
            //dd($id);
            $electronics = electronics::where('id',$id)->first();
            return view('electronics.editElectronics',['electronics'=>$electronics]);
        }
     
        public function updateElectronics(Request $request, $id){
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
            
            $electronics = electronics::where('id',$id)->first();
    
            if(isset($request->image)){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('img'),$imageName);
                $electronics->image = $imageName;
            }
                    
       
        $electronics->name = $request->name;
        $electronics->description = $request->description;
        $electronics->price = $request->price;
       
    
        $electronics->save();
        return redirect()->route('adminElectronics')->withSuccess('electronics Updated');
    
        }
    
        public function deleteElectronics($id){
            $electronics = electronics::findOrFail($id);

            // Delete the image file if it exists
            $imagePath = public_path('img') . '/' . $electronics->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $electronics->delete();
            return back()->withSuccess('electronics Deleted');
        }

        public function electronics(){
            $electronicss = Electronics::all();
            return view('electronics.electronics ',compact('electronicss'));
        }
}
