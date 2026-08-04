<?php

namespace App\Http\Controllers;

use App\Models\Newuser;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    public function index(): View
    {
        return $this->show('overview');
    }

    public function users(): View
    {
        return $this->show('users');
    }

    public function wallets(): View
    {
        return $this->show('wallets');
    }

    private function show(string $section): View
    {
        $subusers = Newuser::query()
            ->where('organization_id', auth()->id())
            ->latest()
            ->get();

        return view('organization.index', [
            'section' => $section,
            'subusers' => $subusers,
            'activeMembers' => $subusers->where('is_active', true),
        ]);
    }
}
