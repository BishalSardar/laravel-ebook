<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\Recent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Cast\Bool_;

class ApiController extends Controller
{
    function allEbook()
    {
        $ebooks = Ebook::all();
        return response([
            'status' => '200',
            'ebook' => $ebooks,
        ]);
    }
    function create(Request $request)
    {

        try {
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

                $ebook->name = $request->name;
            }
            $ebook->save();

            return response([
                'status' => '200',
            ]);
        } catch (Exception $exception) {
            return response([
                'status' => '400',
                'exception' => 'error' . $exception
            ]);
        }
    }

    function singleEbook(Request $request, $id)
    {
        $ebook = Ebook::find($id);

        $recent = new Recent();
        $recent->user_id = $request->user_id;
        $recent->ebook_id = $request->ebook_id;
        $recent->save();

        return response([
            'status' => '200',
            'ebook' => $ebook,
        ]);
    }

    function bookmark(Request $request)
    {
        try {

            $bookmark = new Bookmark();
            $bookmark->user_id = $request->user_id;
            $bookmark->ebook_id = $request->ebook_id;
            $bookmark->save();

            return response([
                'status' => '200',
            ]);
        } catch (Exception $exception) {
            return response([
                'status' => '400',
                'exception' => 'error' . $exception
            ]);
        }
    }

    function allBookmark()
    {
        $bookmark = Bookmark::all();
        return response([
            'status' => '200',
            'bookmark' => $bookmark,
        ]);
    }

    function category()
    {
        $cat = Category::all();
        return response([
            'status' => '200',
            'category' => $cat,
        ]);
    }


    function categoryWiseEbook()
    {
        try {
            $ebooks = DB::table('categories')
                ->join('ebooks', 'categories.id', '=', 'ebooks.category_id')
                ->get()
                ->groupBy('category');


            return response([
                'status' => 200,
                'data' => $ebooks,

            ]);
        } catch (Exception $exception) {
            return response([
                'error' => $exception,

            ]);
        }
    }


    function search(Request $request)
    {
        $name = $request->name;
        $ebook = Ebook::where('name', 'LIKE', $name)->get();
        return response([
            'status' => '200',
            'ebooks' => $ebook
        ]);
    }


    function recentEbook(Request $request)
    {
        $recent_ebook = Recent::where('user_id', $request->user_id)->get();
        return response([
            'status' => '200',
            'ebook' => $recent_ebook
        ]);
    }
}
