<?php namespace Modules\Bcseo\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Bcseo\Entities\Seo;
use Modules\Bcseo\Repositories\SeoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Page\Entities\Page;
use Modules\Blog\Entities\Post;

class SeoController extends AdminBaseController
{
    /**
     * @var SeoRepository
     */
    private $seo;

    public function __construct(SeoRepository $seo)
    {
        parent::__construct();

        $this->seo = $seo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$seos = $this->seo->all();
        $page = new Page;
        $blog = new Post;
        if(File::exists(public_path().'/robots.txt')){
            $robots = File::get(public_path().'/robots.txt');
        }else{
            $robots = '';
        }

        if(File::exists(public_path().'/.htaccess')){
            $htaccess = File::get(public_path().'/.htaccess');
        }else{
            $htaccess = '';
        }
        $pages = $page->all();
        $blogs = $blog->all();

        return view('bcseo::admin.seos.index', compact('robots','htaccess','pages','blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('bcseo::admin.seos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->seo->createOrUpdate($request->all());

        File::put(public_path().'/robots.txt',$request->get('robots'));
        File::put(public_path().'/.htaccess',$request->get('htaccess'));

        return redirect()->route('admin.bcseo.seo.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('bcseo::seos.title.seos')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Seo $seo
     * @return Response
     */
    public function edit(Seo $seo)
    {
        return view('bcseo::admin.seos.edit', compact('seo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Seo $seo
     * @param  Request $request
     * @return Response
     */
    public function update(Seo $seo, Request $request)
    {
        $this->seo->update($seo, $request->all());

        return redirect()->route('admin.bcseo.seo.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('bcseo::seos.title.seos')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Seo $seo
     * @return Response
     */
    public function destroy(Seo $seo)
    {
    }
}
