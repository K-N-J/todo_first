<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('category', compact('categories'));
    }

    public function store(Request $request)
    {
        $validation = $request->validate(
            [
            'name' => ['required', 'string', 'max:10', 'unique:categories'],
            ],
            [
            'name.required' => 'カテゴリを入力してください',
            'name.string' => 'カテゴリを文字列で入力してください',
            'name.max' => 'カテゴリを10文字以下で入力してください',
            'name.unique' => 'カテゴリが既に存在しています',
        ]);

        $category = $request->only(['name']);
        Category::create($category);

        return redirect('/categories')->with('message', 'カテゴリを作成しました');

    }

    public function update(CategoryRequest $request)
    {
        $category = $request->only(['name']);
        Category::find($request->id)->update($category);

        return redirect('/categories')->with('message', 'カテゴリを更新しました');
    }

    public function destroy(Request $request)
    {
        Category::find($request->id)->delete();

        return redirect('/categories')->with('message', 'カテゴリを削除しました');
    }
}
