<?php namespace Modules\Bcseo\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Bcseo\Entities\Seo;
use Modules\Bcseo\Repositories\SeoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

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

        try
        {
            $robots = File::get(public_path().'/robots.txt');
        }
        catch (Illuminate\Filesystem\FileNotFoundException $exception)
        {
            $robots = '';
        }

        try
        {
            $htaccess = File::get(public_path().'/.htaccess');
        }
        catch (Illuminate\Filesystem\FileNotFoundException $exception)
        {
            $htaccess = '';
        }
        return view('bcseo::admin.seos.index', compact('robots','htaccess'));
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

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('bcseo::seos.title.seos')]));

        return redirect()->route('admin.bcseo.seo.index');
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

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('bcseo::seos.title.seos')]));

        return redirect()->route('admin.bcseo.seo.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Seo $seo
     * @return Response
     */
    public function destroy(Seo $seo)
    {
        $this->seo->destroy($seo);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('bcseo::seos.title.seos')]));

        return redirect()->route('admin.bcseo.seo.index');
    }
}
