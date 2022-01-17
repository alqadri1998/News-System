<?php

namespace App\Http\Controllers\CMS;

use App\ContactRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (ControllersService::checkPermission('read-contact-requests','admin')){
            $contactRequests = ContactRequest::paginate(10);
            return view('cms.admin.settings.contact-requests', ['requests' => $contactRequests]);
        }
        return view('cms.blocked');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        //
        if (ControllersService::checkPermission('delete-contact-request', 'admin')) {
            $isDeleted = ContactRequest::destroy($id);
            if ($isDeleted) {
                return response()->json(['icon' => 'success', 'title' => 'Request deleted successfully']);
            } else {
                return response()->json(['icon' => 'error', 'title' => 'Request delete failed']);
            }
        }
        return view('cms.blocked');
    }
}
