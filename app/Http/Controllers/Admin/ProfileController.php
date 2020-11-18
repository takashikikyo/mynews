<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\ProfileHistory;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function add() 
    {
        return view('admin.profile.create');
    }
    
    public function create(Request $request)
    {
      $this->validate($request, Profile::$rules);
      
      $profile = new Profile;
      $form = $request->all();
      
      unset($form['_token']);
      
      $profile->fill($form);
      $profile->save();
      
      return redirect('admin/profile/create');
        
    }     
    
    
    public function edit(Request $request)
    {
    // Profiles Modelからデータを取得する
    $profile = Profile::find($request->id);
    if (empty($profile)) {
    abort(404);
    }
    return view('admin.profile.edit', ['profile_form' => $profile]);
    }
    
    public function update(Request $request) 
    {
        // Validationをかける
      $this->validate($request, Profile::$rules);
      // Profiles Modelからデータを取得する
      $profile = Profile::find($request->id);
      // 送信されてきたフォームデータを格納する
      $profile_form = $request->all();

      // unset($profiles_form['remove']);
      unset($profile_form['_token']);
      // 該当するデータを上書きして保存する
      $profile->fill($profile_form)->save();
      
      $profilehistories = new ProfileHistory;
      $profilehistories->profile_id = $profile->id;
      $profilehistories->edited_at = Carbon::now();
      $profilehistories->save();
      
      return redirect('admin/profile/edit');
    }
    
    
    public function delete(Request $request)
    {
      // 該当するNews Modelを取得
      $profile = Profile::find($request->id);
      // 削除する
      $profile->delete();
      return redirect('admin/profile/create');
    }
}


