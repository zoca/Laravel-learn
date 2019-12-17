<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Page;

class FrontendController extends Controller
{
    public function page(Page $page)
    {
        return view('frontend.page.show', compact('page'));
    }
}
