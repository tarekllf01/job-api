<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use File;
use Carbon\Carbon;

class PostController extends Controller
{
    public function __construct()
    {
        $this->successStatus = 200;
        $this->createdStatus = 201;
        $this->noContentStatus = 204;
        $this->badRequestStatus = 400;
        $this->unAuthorizedStatus = 401;
        $this->forbiddenStatus = 403;
        $this->notFoundStatus = 404;
        $this->notAcceptableStatus = 406;
        $this->unproccessableEntryStatus = 422;
    }

    public function index()
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        if ($response['data']= Post::select('id','title','description','created_at as createdAt')->where('status',1)->get()) {
            return response()->json($response,$this->successStatus);
        }
        $response['message'] = "No content";
        return response()->json($response,$this->noContentStatus);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    public function store(Request $request)
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        $post = new Post();
        if ($this->save($post,$request)) {
            $response['message'] = "Post Created Successfully";
            $response['data'] =  [  
                                    'id' => $post->id,'title' => $post->title,'description' => $post->description,
                                    'thumbnail' => asset('storage/'.$post->thumbnail),'status' => $post->status,
                                    'user' => $post->userInfo->name??'', 'createdAt' => Carbon::parse($post->created_at)->format('d/m/Y h:i:s a')
                                ];
            return response()->json($response,$this->createdStatus);
        }
        $response['message'] = "Post could not create, try again";
        return response()->json($response,$this->unproccessableEntryStatus);
    }

    public function show($id)
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        if ($post = Post::find($id)) {
            $response['data'] = [
                'id' => $post->id,'title' => $post->title,'description' => $post->description,
                'thumbnail' => asset('storage/'.$post->thumbnail),'status' => $post->status,
                'user' => $post->userInfo->name??'', 'createdAt' => Carbon::parse($post->created_at)->format('d/m/Y h:i:s a')
             ];
            return response()->json($response,$this->successStatus);
        }
        $response['message'] = "No post found";
        return response()->json($response,$this->notFoundStatus);

    }

    public function update(Request $request, $id)
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        $post = Post::find ($id);
        if ($post && $this->save($post,$request)) {
            $response['message'] = "Post updated Successfully";
            $response['data'] = [
                                    'id' => $post->id,'title' => $post->title,'description' => $post->description,
                                    'thumbnail' => asset('storage/'.$post->thumbnail),'status' => $post->status,
                                    'user' => $post->userInfo->name??'', 'createdAt' => Carbon::parse($post->created_at)->format('d/m/Y h:i:s a')
                                 ];
            return response()->json($response,$this->successStatus);
        }
        $response['message'] = "Post could not be updated.";
        return response()->json($response,$this->unproccessableEntryStatus);
    }

    public function destroy($id)
    {
        $response = array();
        $response['message'] = null;
        $response['data'] = null;
        $post = Post::find($id);
        $exFile = $post->thumbnail??null;
        if ($post && $post->delete()) {
            if(File::exists(public_path('storage/'.$exFile))){
                File::delete(public_path('storage/'.$exFile));
            }
            $response['message'] = "successfully deleted";
            return response()->json($response,$this->successStatus);
        }
        $response['message'] = "Post could not be deleted";
        return response()->json($response,$this->unproccessableEntryStatus);
    }

    private function save(Post $post,Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:20',
            'status' => 'required|in:0,1',
        ]);
        if (isset($post->id) && $post->id != null) {
            $request->validate([
                'thumbnail' => 'nullable|image|max:10000',
            ]);
        } else {
            $request->validate([
                'thumbnail' => 'required|image|max:10000',
            ]);
        }

        $post->title = trim($request->title);
        $post->description = trim($request->description);
        $post->status = $request->status;
        $exFile = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail')->store('thumbnail','public');
            if ($post->thumbnail) {
                $exFile = $post->thumbnail;
            }
            $post->thumbnail = $file;
        }
        $post->updated_by_user_id = $post->user_id?Auth::id():null;
        $post->user_id = $post->user_id??Auth::id();

        if ($post->save()) {
            if(File::exists(public_path('storage/'.$exFile))){
                File::delete(public_path('storage/'.$exFile));
            }
            return true;
        }
        return false;
    }
}
