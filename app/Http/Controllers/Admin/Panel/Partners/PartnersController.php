<?php

namespace App\Http\Controllers\Admin\Panel\Partners;

use Illuminate\Http\Request;
use App\Helpers\Traits\FilterBy;
use App\Models\Partners\Partner;
use App\Http\Requests\Partners\StoreRequest;
use App\Http\Requests\Partners\UpdateRequest;
use App\Http\Controllers\Admin\BaseAdminController;

class PartnersController extends BaseAdminController
{
    use FilterBy;

    protected $partner;

    public function __construct(Partner $partner)
    {
        parent::__construct();

        $this->partner = $partner;
    }

    public function index(Request $request)
    {
        $this->authorize('view', Partner::class);

        $total = $this->partner->count();
        $partners = $this->filterBy($this->partner, $request, ['name', 'email', 'donation', 'donation_time'])
            ->orderBy('name')
            ->paginate(self::PAGINATION);

        return view('panel.partners.index', compact('partners', 'request', 'total'));
    }

    public function deleted(Request $request)
    {
        $this->authorize('delete', Partner::class);

        $total = $this->partner->count();
        $partners = $this->filterBy($this->partner->onlyTrashed(), $request, ['name', 'email', 'donation', 'donation_time'])
            ->orderBy('name')
            ->paginate(self::PAGINATION);

        return view('panel.partners.deleted', compact('partners', 'request', 'total'));
    }

    public function show($id)
    {
        $this->authorize('view', Partner::class);

        $partner = $this->partner
            ->findOrFail($id);

        return view('panel.partners.show', compact('partner'));
    }

    public function create()
    {
        $this->authorize('create', Partner::class);

        return view('panel.partners.create');
    }

    public function store(StoreRequest $request)
    {
        $this->authorize('create', Partner::class);

        $partner = $this->partner
            ->create($request->all());

        flash('Socio creado correctamente.');

        return redirect()->route('admin::panel::partners::edit', ['id' => $partner->id]);
    }

    public function edit($id)
    {
        $partner = $this->partner
            ->findOrFail($id);

        $this->authorize('update', $partner);

        return view('panel.partners.edit', compact('partner'));
    }

    public function update(UpdateRequest $request, $id)
    {
        $partner = $this->partner
            ->findOrFail($id);

        $this->authorize('update', $partner);
        $partner->update($request->all());

        flash('Socio actualizado correctamente.');

        return redirect()->route('admin::panel::partners::edit', ['id' => $id]);
    }

    public function restore($id)
    {
        $partner = $this->partner
            ->withTrashed()
            ->where('id', $id)->firstOrFail();

        $this->authorize('delete', $partner);
        $partner->restore();

        flash('El socio se ha recuperado correctamente.');

        return redirect()->route('admin::panel::partners::index');
    }

    public function delete($id)
    {
        $partner = $this->partner
            ->withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $this->authorize('delete', $partner);
        $partner->delete();

        flash('El socio se ha eliminado correctamente.');

        return redirect()->route('admin::panel::partners::index');
    }
}
