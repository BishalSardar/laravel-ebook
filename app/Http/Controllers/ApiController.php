<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Ebook;
use Exception;
use Illuminate\Http\Request;
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
}
