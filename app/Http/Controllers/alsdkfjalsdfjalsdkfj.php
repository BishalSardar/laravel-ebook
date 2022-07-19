if ($ebook->image && $ebook->pdf) {
$imgFile = $ebook->image;
$imgFileName = $imgFile->getClientOriginalName();
$imgFile->move(public_path('Image'), $imgFileName);
$bookmark['image'] = $imgFileName;

$pdfFile = $ebook->pdf;
$pdfFileName = $pdfFile->getClientOriginalName();
$pdfFile->move(public_path('PDF'), $pdfFileName);
$bookmark['pdf'] = $pdfFileName;

$bookmark->name = $ebook->name;
}
$bookmark->save();



$cat_arr = array('All', 'Comic', 'Fantasy');
$data = new Category();
for ($i = 0; $i < count($cat_arr); $i++) { $data->category = $cat_arr[$i];
    $data->save();
    };
    return $cat_arr;