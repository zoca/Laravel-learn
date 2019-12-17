<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Null_;

class Page extends Model
{
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function scopeNotdeleted($query)
    {
        return $query->where('deleted', 0);
    }

    public function scopeTopLevel($query)
    {
        return $query->where('page_id', 0);
    }

    public function breadcrumbs($parent = null)
    {
        if (is_null($parent)) {
            $page = $this;
        } else {
            $page = $parent;
        }

        if ($page->page_id != 0) {
            $page->breadcrumbs($page->page);
            echo '/ <a>' . $page->title . '</a> ';
        } else {
            echo '/ <a href="' . route('pages.index', ['page' => $page->id]) . '">' . $page->title . '</a> ';
        }
    }
}
