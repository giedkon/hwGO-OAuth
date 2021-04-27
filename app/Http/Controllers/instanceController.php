<?php

namespace App\Http\Controllers;

use App\Http\Requests\instanceCreateRequest;
use App\Http\Requests\instanceEditRequest;
use App\Models\Instance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class instanceController extends Controller
{
    public function userInstances(Request $request)
    {
        return $request->user()->instances;
    }

    public function create(instanceCreateRequest $request)
    {
        $user = $request->user();
        try {
            if ($request->hasFile('image')) {
                $instance = Instance::create([
                    'name' => $request['name'],
                ]);
                $imageLocation = Storage::disk('public')->put('instances/instance_'.$instance->id, $request->file('image'));
                $resizedLocation = 'storage/instances/instance_'.$instance->id.'/';

                Image::make('storage/'.$imageLocation)->heighten( 64)->save($resizedLocation.'resized_small.png');
                Image::make('storage/'.$imageLocation)->heighten( 256)->save($resizedLocation.'resized_medium.png');
                Image::make('storage/'.$imageLocation)->heighten(768)->save($resizedLocation.'resized_large.png');

                Storage::disk('public')->delete($imageLocation);

                $instance->image = $resizedLocation.'resized_large.png';
                $instance->image_medium = $resizedLocation.'resized_medium.png';
                $instance->image_small = $resizedLocation.'resized_small.png';

                $instance->save();
            } else {
                $instance = Instance::create([
                    'name' => $request['name'],
                    'image' => null
                ]);
            }
            $instance->users()->save($user);
            return $instance;
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }
    public function update(instanceEditRequest $request)
    {
        $user = $request->user();
        try {
            $instance = Instance::findOrFail($request['id']);
            if ($request->hasFile('image')) {
                $instance->name = $request['name'];

                $imageLocation = Storage::disk('public')->put('instances/instance_'.$instance->id, $request->file('image'));
                $resizedLocation = 'storage/instances/instance_'.$instance->id.'/';

                Image::make('storage/'.$imageLocation)->heighten( 64)->save($resizedLocation.'resized_small.png');
                Image::make('storage/'.$imageLocation)->heighten( 256)->save($resizedLocation.'resized_medium.png');
                Image::make('storage/'.$imageLocation)->heighten(768)->save($resizedLocation.'resized_large.png');

                Storage::disk('public')->delete($imageLocation);

                $instance->image = $resizedLocation.'resized_large.png';
                $instance->image_medium = $resizedLocation.'resized_medium.png';
                $instance->image_small = $resizedLocation.'resized_small.png';

                $instance->save();
            } else {
                $instance->name = $request['name'];
                $instance->save();
            }
            $instance->users()->save($user);
            return $instance;
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }
    public function destroy($id)
    {
        try {
            $instance = Instance::findOrFail($id);

            $user_owns = DB::table('instance_user')
                    ->where('instance_id', '=', $instance->id)
                    ->where('user_id', '=', Auth::user()->id)
                    ->count() > 0;
            if ($user_owns) {
                $instance->delete();
                return response()->json('Instance successfully removed', 200);
            } else {
                return response()->json('User does not own this Instance.', 422);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json("Instance not found.", 422);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }
}
