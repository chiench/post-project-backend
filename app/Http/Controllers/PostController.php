<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    public function getListPost(Request $request)
    {
        $per_page = $request->get('per_page', 20);
        $page = $request->get('page', 1);
        $query = Post::query();
        $query = $this->filterIndex($query, $request);
        $data = $query->orderBy('updated_at', 'desc')
            ->paginate($per_page, ['*'], 'page', $page);
        return response()->json($data, 200);
    }
    public function filterIndex($query, $request)
    {
        $search = $request->has('search') ? $request->get('search') : null;
        if (!is_null($search)) {
            $search = trim($search);
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        }
        return $query;
    }
    public function getDetalsPost($id)
    {
        $data = Post::find($id);
        return response()->json(['data' => $data], 200);

    }
    public function addPost(Request $request)
    {

        $messages = [
            'title.required' => 'Trường title là được yêu cầu.',
            'content.required' => 'Trường content là được yêu cầu.',
            'title.max' => 'Trường title không quá 255 ký tự.',
            'title.unique' => 'Giá trị trong trường title phải riêng biệt.',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title|max:255',
            'content' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $post = Post::create($validated);
        return response()->json([
            'data' => $post,
            'message' => 'Thêm mới thành công',
            'status' => 200,
        ], 200);

    }
    public function editPost(Request $request, $id)
    {
        $messages = [
            'title.required' => 'Trường title là được yêu cầu.',
            'content.required' => 'Trường content là được yêu cầu.',
            'title.max' => 'Trường title không quá 255 ký tự.',
            'title.unique' => 'Giá trị trong trường title phải riêng biệt.',
        ];
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:posts,title,|max:255',
            'content' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $validated = $validator->validated();
        $post = tap(Post::findOrFail($id))->update($validated)->fresh();
        return response()->json([
            'data' => $post,
            'message' => 'Cập nhật thành công'
        ], 200);

    }
    public function deletePost(Request $request, $id)
    {
        $post = tap(Post::findOrFail($id))->delete()->fresh();
        return response()->json([
            'data' => $post,
            'message' => 'Xóa thành công',
            'status' => 200,
        ]);
    }
}