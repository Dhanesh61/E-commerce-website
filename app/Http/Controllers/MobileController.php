<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobile;
use App\Http\Controllers\Controller;

class MobileController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware('verified');
    //     $this->middleware('admin.role')->only('index'); 
    // }
    
    public function adminmobile()
    {
        $mobiles = Mobile::all();
        return view('product.adminmobile',compact('mobiles'));
    }

    public function createmobile(){
        return view('product.createmobile');
    }
    
    
        public function storemobile(Request $request){
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
    
            $mobile = new mobile;
            $mobile->image = $imageName;
            $mobile->name = $request->name;
            $mobile->description = $request->description;
            $mobile->price = $request->price ?? 0;
    
            $mobile->save();
             return redirect()->route('adminmobile')->withSuccess('mobile Created');
        }
        public function editmobile($id){
            //dd($id);
            $mobile = mobile::where('id',$id)->first();
            return view('product.editmobile',['mobile'=>$mobile]);
        }
     
        public function updatemobile(Request $request, $id){
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
            
            $mobile = mobile::where('id',$id)->first();
    
            if(isset($request->image)){
                $imageName = time().'.'.$request->image->extension();
                $request->image->move(public_path('img'),$imageName);
                $mobile->image = $imageName;
            }
                    
       
        $mobile->name = $request->name;
        $mobile->description = $request->description;
        $mobile->price = $request->price;
       
    
        $mobile->save();
        return redirect()->route('adminmobile')->withSuccess('product Updated');
    
        }
    
        public function deletemobile($id){
            $mobile = Mobile::findOrFail($id);

            // Delete the image file if it exists
            $imagePath = public_path('img') . '/' . $mobile->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $mobile->delete();
            return back()->withSuccess('mobile Deleted');
        }

        public function mobile(){
            $mobiles = Mobile::all();
            return view('product.mobile',compact('mobiles'));
        }
}
