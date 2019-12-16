<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Page;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page)
    {
        if (isset($page->id) && !empty($page->id)) {
            $rows = Page::where('page_id', '=', $page->id)
                ->notdeleted()
                ->get();
        } else {
            $rows = Page::topLevel()
                ->notdeleted()
                ->get();
        }

        $pagesIds = Page::groupBy('page_id')->pluck('page_id')->all();
        //dd($pagesIds);     
        return view('admin.pages.index', compact('rows', 'pagesIds', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Page $page)
    {
        $pagesTopLevel = Page::topLevel()
            ->notdeleted()
            ->get();
        return view('admin.pages.create', compact('pagesTopLevel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pagesIds = Page::pluck('id')->all();   // pluck vraca niz svih id-eva
        $pagesIds[] = 0;                        // stavljam nulu u niz id-eva jer u bazi nema id 0 
        $pagesIds = implode(",", $pagesIds);
        // validacija
        $data = request()->validate([            // request->validate vraca niz sa validirani podacima, ali ovo nema u svim verzijama Laravel-a     
            'page_id' => 'required|integer|in:' . $pagesIds,
            'title' => 'required|string|min:3|max:191',
            'description' => 'required|string|max:191',
            'image' => 'required|image|mimes:jpeg,bmp,png,jpg',
            'content' => 'required|string|max:65000',
            'layout' => 'required|string|in:fullwidth,leftaside,rightaside',
            'contact_form' => 'required|boolean',
            'header' => 'required|boolean',
            'aside' => 'required|boolean',
            'footer' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        $row = new Page();

        unset($data['image']);              // unsetovan image da ne bi prosao kroz petlju, ali je posle postavljen na prazan string dok se ne uploaduje

        foreach ($data as $key => $value) {
            $row->$key = $value;
        }

        $row->image = "";
        // provera da li dolazi 'image' kroz request
        if (request()->has('image')) {
            $file = request()->image;
            $fileExtension = $file->getClientOriginalExtension();

            $fileName = $file->getClientOriginalName();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = config('app.seo-image-prefiks') . $fileName . '-' . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '.' . $fileExtension;
            //echo public_path('/upload/pages/');
            $file->move(public_path('/upload/pages/'), $fileName);

            $row->image = '/upload/pages/' . $fileName;

            //intervention
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameM = '/upload/pages/' . config('app.seo-image-prefiks') . $fileName . '-' . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-m.' . $fileExtension;

            $interventionImage->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameS = '/upload/pages/' . config('app.seo-image-prefiks') . $fileName . '-' . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-s.' . $fileExtension;

            $interventionImage->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameL = '/upload/pages/' . config('app.seo-image-prefiks') . $fileName . '-' . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-l.' . $fileExtension;

            $interventionImage->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNamXl = '/upload/pages/' . config('app.seo-image-prefiks') . $fileName . '-' . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-xl.' . $fileExtension;

            $interventionImage->save(public_path($fileNameM));
        }

        $row->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully created page ' . $row->title . '!!!');

        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
