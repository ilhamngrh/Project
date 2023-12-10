<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('blog.create');
    }


    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:png,jpg,jpeg',
            'title'     => 'required',
            'content'   => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/blogs', $image->hashName());

        $blog = Blog::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        if ($blog) {
            //redirect dengan pesan sukses
            return redirect()->route('blog.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('blog.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    // function edit data

    // memerintahkan untuk diarahkan ke view/blog/edit
    public function edit(Blog $blog)
    {
        return view('blog.edit', compact('blog'));
    }
    // akhir memerintahkan untuk diarahkan ke view/blog/edit

    // proses simpan data yang telah diedit
    public function update(Request $request, Blog $blog)
    {
        $this->validate($request, [
            'title'     => 'required',
            'content'   => 'required'
        ]);

        //get data Blog by ID
        $blog = Blog::findOrFail($blog->id);

        if ($request->file('image') == "") {

            $blog->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        } else {

            //hapus old image
            Storage::disk('local')->delete('public/blogs/' . $blog->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/blogs', $image->hashName());

            $blog->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'content'   => $request->content
            ]);
        }

        if ($blog) {
            //redirect dengan pesan sukses
            return redirect()->route('blog.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('blog.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    // akhir proses simpan data yang telah diedit

    // proses hapus data
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        Storage::disk('local')->delete('public/blogs/' . $blog->image); //baris untuk menghapus image pada storage. ketika data dihapus maka file gambar juga yang tersimpan ikut terhapus
        $blog->delete();

        if ($blog) {
            //redirect dengan pesan sukses
            return redirect()->route('blog.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('blog.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
    // akhir proses hapus data
}
