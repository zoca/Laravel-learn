<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Page;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page = null)
    {
        // if (isset($page->id) && !empty($page->id)) {
        //     $rows = Page::where('page_id', '=', $page->id)
        //         ->notdeleted()
        //         ->get();
        // } else {
        //     $rows = Page::topLevel()
        //         ->notdeleted()
        //         ->get();
        // }
        // level 0 - toplevel
        if (is_null($page)) {
            $pageId = 0;
        } else {
            // subpages
            $pageId = $page->id;
        }

        $rows = Page::notdeleted()
            ->where('page_id', $pageId)
            ->orderbyordnum()
            ->get();

        $pagesIds = Page::groupBy('page_id')->pluck('page_id')->all();
        //dd($pagesIds);     
        return view('admin.pages.index', compact(['rows', 'pagesIds', 'page']));
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

            $timeStamp = Str::slug(now(), '-');

            $fileName = $file->getClientOriginalName();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '.' . $fileExtension;
            //echo public_path('/upload/pages/');
            $file->move(public_path('/upload/pages/'), $fileName);

            $row->image = '/upload/pages/' . $fileName;

            //intervention
            // xl velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(1140, null, function ($constraint) {
                $constraint->aspectRatio();
            });           
            $fileNameXl = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-xl.' . $fileExtension;
            $interventionImage->save(public_path($fileNameXl));
              //intervention
            // l velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameL = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-l.' . $fileExtension;
            $interventionImage->save(public_path($fileNameL));
            //intervention
            // m velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameM = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-m.' . $fileExtension;
            $interventionImage->save(public_path($fileNameM));
            //intervention
            // s velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameS = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-s.' . $fileExtension;
            $interventionImage->save(public_path($fileNameS));              
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
    public function edit(Page $page)
    {
        $pagesTopLevel = Page::topLevel()
            ->notdeleted()
            ->where('id', '!=', $page->id)
            ->get();
        return view('admin.pages.edit', compact(['page', 'pagesTopLevel']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Page $page)
    {
        
        $pagesIds = Page::pluck('id')->all();   // pluck vraca niz svih id-eva
        $pagesIds[] = 0;                        // stavljam nulu u niz id-eva jer u bazi nema id 0 
        $pagesIds = implode(",", $pagesIds);
        // validacija
        $data = request()->validate([            // request->validate vraca niz sa validirani podacima, ali ovo nema u svim verzijama Laravel-a     
            'page_id' => 'required|integer|in:' . $pagesIds,
            'title' => 'required|string|min:3|max:191',
            'description' => 'required|string|max:191',
            'image' => 'nullable|image|mimes:jpeg,bmp,png,jpg',
            'content' => 'required|string|max:65000',
            'layout' => 'required|string|in:fullwidth,leftaside,rightaside',
            'contact_form' => 'required|boolean',
            'header' => 'required|boolean',
            'aside' => 'required|boolean',
            'footer' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

       

        $row = $page;

        unset($data['image']);             // unsetovan image da ne bi prosao kroz petlju, ali je posle postavljen na prazan string dok se ne uploaduje
        foreach ($data as $key => $value) {
            $row->$key = $value;
        }

        $row->image = $page->image;
        // provera da li dolazi 'image' kroz request
        if (request()->has('image')) {
            $file = request()->image;
            $fileExtension = $file->getClientOriginalExtension();

            $timeStamp =Str::slug(now(), '-');

            $fileName = $file->getClientOriginalName();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '.' . $fileExtension;
            //echo public_path('/upload/pages/');
            $file->move(public_path('/upload/pages/'), $fileName);

            $row->image = '/upload/pages/' . $fileName;

            //intervention
            // xl velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(1140, null, function ($constraint) {
                $constraint->aspectRatio();
            });           
            $fileNameXl = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-xl.' . $fileExtension;
            $interventionImage->save(public_path($fileNameXl));
              //intervention
            // l velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameL = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-l.' . $fileExtension;
            $interventionImage->save(public_path($fileNameL));
            //intervention
            // m velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameM = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-m.' . $fileExtension;
            $interventionImage->save(public_path($fileNameM));
            //intervention
            // s velicina
            $interventionImage = Image::make(public_path('/upload/pages/') . $fileName);
            $interventionImage->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameS = '/upload/pages/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . $timeStamp . '-s.' . $fileExtension;
            $interventionImage->save(public_path($fileNameS));              
        }

        $row->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully edit page ' . $row->title . '!!!');

        return redirect()->route('pages.index');
    }

    public function delete(Page $page)
    {
        //hard delete
        //$page->delete();

        //soft delete
        $page->deleted = 1;
        $page->deleted_by = auth()->user()->id;
        $page->deleted_at = now();
        $page->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully deleted page ' . $page->title . '!!!');

        return redirect()->route('pages.index');
    }

    public function changestatus(Page $page)
    {
        if ($page->active == 1) {
            $page->active = 0;
        } else {
            $page->active = 1;
        }

        $page->save();

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for page ' . $page->name . '!!!');

        return redirect()->route('pages.index');
    }
}


