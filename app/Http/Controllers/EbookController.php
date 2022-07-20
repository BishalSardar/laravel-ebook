<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Exception;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat_arr = array('All', 'Comic', 'Fantasy');
        $data = new Category();
        for ($i = 0; $i < count($cat_arr); $i++) {
            $data->category = $cat_arr[$i];
            $data->save();
        };
        return $cat_arr;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $ebook = new Ebook();

            if ($request->file('image') && $request->file('pdf')) {
                $imgFile = $request->file('image');
                $imgFileName = $imgFile->getClientOriginalName();
                $imgFile->move(public_path('Image'), $imgFileName);
                $ebook['image'] = $imgFileName;

                $pdfFile = $request->file('pdf');
                $pdfFileName = $pdfFile->getClientOriginalName();
                $pdfFile->move(public_path('PDF'), $pdfFileName);
                $ebook['pdf'] = $pdfFileName;
            }
            $ebook->name = $request->name;
            $ebook->category_id = $request->category_id;
            $ebook->save();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function show(Ebook $ebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function edit(Ebook $ebook, $id)
    {
        $item = Ebook::find($id);
        $categories = Category::all();
        return view('update', compact('item', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ebook $ebook, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $ebook = Ebook::find($id);

            if ($request->file('image') && $request->file('pdf')) {
                $imgFile = $request->file('image');
                $imgFileName = $imgFile->getClientOriginalName();
                $imgFile->move(public_path('Image'), $imgFileName);
                $ebook['image'] = $imgFileName;

                $pdfFile = $request->file('pdf');
                $pdfFileName = $pdfFile->getClientOriginalName();
                $pdfFile->move(public_path('PDF'), $pdfFileName);
                $ebook['pdf'] = $pdfFileName;
            }
            $ebook->name = $request->name;
            $ebook->category_id = $request->category_id;
            $ebook->update();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }

        return redirect()->route('home');
    }

    public function delete($id)
    {
        $data = Ebook::find($id);
        $data->delete();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ebook  $ebook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ebook $ebook)
    {
        //
    }

    function category(Request $request)
    {
        try {
            $cat = new Category();
            $cat->category = $request->category;
            $cat->save();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }
        return redirect()->back();
    }
}
