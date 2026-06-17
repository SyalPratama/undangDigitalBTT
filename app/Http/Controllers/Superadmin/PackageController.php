<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Package;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->paginate(10);
        return view('superadmin.packages.index', compact('packages'));
    }

    public function create()
    {
        $package = new Package();
        return view('superadmin.packages.form', compact('package'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'active_days' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $data['is_premium_template_access'] = $request->has('is_premium_template_access');
        $data['has_auto_guest_name'] = $request->has('has_auto_guest_name');
        $data['has_event_countdown'] = $request->has('has_event_countdown');
        $data['has_google_maps'] = $request->has('has_google_maps');
        $data['has_photo_gallery'] = $request->has('has_photo_gallery');
        $data['has_love_story'] = $request->has('has_love_story');
        $data['has_background_music'] = $request->has('has_background_music');
        $data['has_digital_envelope'] = $request->has('has_digital_envelope');
        $data['has_guest_comments'] = $request->has('has_guest_comments');
        $data['has_rsvp'] = $request->has('has_rsvp');
        $data['has_rsvp_stats'] = $request->has('has_rsvp_stats');
        $data['has_realtime_tracking'] = $request->has('has_realtime_tracking');
        $data['has_opened_list'] = $request->has('has_opened_list');
        $data['has_unopened_list'] = $request->has('has_unopened_list');
        $data['has_monitoring_dashboard'] = $request->has('has_monitoring_dashboard');
        $data['is_active'] = $request->has('is_active');
        $data['features_json'] = []; // No longer using text area

        Package::create($data);

        return redirect()->route('superadmin.packages.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit(Package $package)
    {
        return view('superadmin.packages.form', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'active_days' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $data['is_premium_template_access'] = $request->has('is_premium_template_access');
        $data['has_auto_guest_name'] = $request->has('has_auto_guest_name');
        $data['has_event_countdown'] = $request->has('has_event_countdown');
        $data['has_google_maps'] = $request->has('has_google_maps');
        $data['has_photo_gallery'] = $request->has('has_photo_gallery');
        $data['has_love_story'] = $request->has('has_love_story');
        $data['has_background_music'] = $request->has('has_background_music');
        $data['has_digital_envelope'] = $request->has('has_digital_envelope');
        $data['has_guest_comments'] = $request->has('has_guest_comments');
        $data['has_rsvp'] = $request->has('has_rsvp');
        $data['has_rsvp_stats'] = $request->has('has_rsvp_stats');
        $data['has_realtime_tracking'] = $request->has('has_realtime_tracking');
        $data['has_opened_list'] = $request->has('has_opened_list');
        $data['has_unopened_list'] = $request->has('has_unopened_list');
        $data['has_monitoring_dashboard'] = $request->has('has_monitoring_dashboard');
        $data['is_active'] = $request->has('is_active');
        $data['features_json'] = []; // No longer using text area

        $package->update($data);

        return redirect()->route('superadmin.packages.index')->with('success', 'Paket berhasil diupdate');
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('superadmin.packages.index')->with('success', 'Paket berhasil dihapus');
    }
}
