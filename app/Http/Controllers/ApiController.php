<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Ebook;
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
                'status' => '200'
            ]);
        } catch (Exception $exception) {
            return response([
                'status' => '400',
                'exception' => 'error' . $exception
            ]);
        }
    }

    function singleEbook($id)
    {
        $ebook = Ebook::find($id);

        return response([
            'status' => '200',
            'ebook' => $ebook,
        ]);
    }

    function bookmark(Request $request, $id)
    {
        try {
            $ebook = Ebook::find($id);
            $bookmark = new Bookmark();

            if ($ebook['image'] && $ebook['pdf']) {
                $bookmark['image'] = $ebook['image'];
                $bookmark['pdf'] = $ebook['pdf'];
                $bookmark->name = $ebook['name'];
                $bookmark->save();
            }

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
                ->get();

            $category_data = Category::all();

            $ebooks_with_cat = array();

            for ($i = 0; $i < count($category_data); $i++) {
                $cat_with_data = collect($ebooks)->where('category_id', $i + 1)->all();
                $cat_data = array($category_data[$i]['category'] => $cat_with_data);
                array_push($ebooks_with_cat, $cat_data);
            }


            return response([
                'status' => 200,
                'data' => $ebooks_with_cat,

            ]);
        } catch (Exception $exception) {
            return response([
                'error' => $exception,

            ]);
        }
    }
}
