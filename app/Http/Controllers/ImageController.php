<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\User;

class ImageController extends Controller
{
    public function dropzoneform()
    {
        $users = User::orderBy('created_at', 'asc')->get();


        return view('welcome', [
            'users' => $users,
        ]);
    }


    public function storeData(Request $request)
    {

        try {
            $user = new User;
            $user->name = $request->name;
            $user->descr = $request->descr;
            $user->image = 'image';
            $user->save();
            $user_id = $user->id; // возвращает последний айди записи(пользователя)
        } catch (\Exception $e) {
            return response()->json(['status' => 'exception', 'msg' => $e->getMessage()]);
        }
        return response()->json(
            [
                'status' => "success",
                'user_id' => $user_id
            ]
        );
    }



    // отправка изображение вместе с айди пользователя, и с помощью айди пользователя обновляется запись
    public function storeImage(Request $request)
    {
        if ($request->file('file')) {

            $img = $request->file('file');

            $userid = $request->userid;

            // генерация имени изображения
            $imageName = strtotime(now()) . rand(11111, 99999) . '.' . $img->getClientOriginalExtension();
            $user_image = new User();
            $original_name = $img->getClientOriginalName();
            $user_image->image = $imageName;

            if (!is_dir(public_path() . '/uploads/images/')) {
                mkdir(public_path() . '/uploads/images/', 0777, true);
            }

            $request->file('file')->move(public_path() . '/uploads/images/', $imageName);

            // обновление столбеца изображения с помощью айди пользователя
            $user_image->where('id', $userid)->update(['image' => $imageName]);

            return response()->json(['status' => "success", 'imgdata' => $original_name, 'userid' => $userid]);
        }
    }
}
