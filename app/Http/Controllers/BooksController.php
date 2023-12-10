<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BooksController extends Controller
{
    public function index()
    {
        $books = Books::latest()->paginate(10);
        return view('book.index', compact('books'));
    }

    public function create()
    {
        return view('book.create');
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
            // 'image'     => 'required|image|mimes:png,jpg,jpeg',
            'books_name'     => 'required',
            'author'   => 'required'
        ]);

        //upload image
        // $image = $request->file('image');
        // $image->storeAs('public/books', $image->hashName());

        $book = Books::create([
            // 'image'     => $image->hashName(),
            'books_name'     => $request->books_name,
            'author'   => $request->author
        ]);

        if ($book) {
            //redirect dengan pesan sukses
            return redirect()->route('book.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('book.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    // function edit data

    // memerintahkan untuk diarahkan ke view/book/edit
    public function edit(Books $book)
    {
        return view('book.edit', compact('book'));
    }
    // akhir memerintahkan untuk diarahkan ke view/book/edit

    // proses simpan data yang telah diedit
    public function update(Request $request, Books $book)
    {
        $this->validate($request, [
            'books_name'     => 'required',
            'author'   => 'required'
        ]);

        //get data book by ID
        $book = Books::findOrFail($book->id);

        if ($request->file('image') == "") {

            $book->update([
                'books_name'     => $request->books_name,
                'author'   => $request->author,

            ]);
        } else {

            // //hapus old image
            // Storage::disk('local')->delete('public/books/' . $book->image);

            // //upload new image
            // $image = $request->file('image');
            // $image->storeAs('public/books', $image->hashName());

            $book->update([
                // 'image'     => $image->hashName(),
                'books_name'     => $request->books_name,
                'author'   => $request->author,
                'publish'   => $request->publish
            ]);
        }

        if ($book) {
            //redirect dengan pesan sukses
            return redirect()->route('book.index')->with(['success' => 'Data Berhasil Diupdate!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('book.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }
    // akhir proses simpan data yang telah diedit

    // proses hapus data
    public function destroy($id)
    {
        $book = Books::findOrFail($id);
        // Storage::disk('local')->delete('public/books/' . $book->image); //baris untuk menghapus image pada storage. ketika data dihapus maka file gambar juga yang tersimpan ikut terhapus
        $book->delete();

        if ($book) {
            //redirect dengan pesan sukses
            return redirect()->route('book.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('book.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
    // akhir proses hapus data
}
