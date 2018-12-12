<?php

namespace App\Http\Controllers\Business_admin;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessAdmin;
use App\Models\BusinessPromotion;
use App\Models\BusinessUser;
use App\Models\PromotionSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Profile;
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use Auth;
use Response;
use Validator;
class PromotionController extends Controller
{
    /**
     * Show the application Promotions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bzname)
    {
        $user = Auth::guard('business')->user();
        $business = Business::where('business_name', $bzname)->first();

        $promotions = PromotionSetting::join('business_promotions', 'promotion_id', '=', 'business_promotions.id')
            ->select('promotion_settings.*', 'business_promotions.path')
            ->where('promotion_settings.business_id', $business->id)->get();

        $data = [
            'user' => $user,
            'promotions' => $promotions,
            'bzname' => $bzname,
        ];

        return View('pages.business_admin.promotions.show-promotions', $data);
    }

    /**
     * Edit a existing User
     */
    public function edit($bzname, $id)
    {
        $user = Auth::guard('business')->user();
        $promotion = PromotionSetting::findOrFail($id);
        $business = Business::where('business_name', $bzname)->first();
        $promotions = BusinessPromotion::where('business_id', $business->id)->get();

        $data = [
            'promotion' => $promotion,
            'user' => $user,
            'bzname' => $bzname,
            'promotions' => $promotions,
        ];

        return view('pages.business_admin.promotions.edit-promotion', $data);
    }

    /**
     * Update a existing user resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update($bzname, $id, Request $request)
    {
        $user = Auth::guard('business')->user();
        $promotion = PromotionSetting::findOrFail($id);
        $input = $request->except('_token', '_method');

        if ($promotion->default == false) {
            $validator = Validator::make($request->all(), [
                'title'     => 'required',
                'start_date'    => 'required',
                'end_date' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
        }

        if(isset($input['start_date'])) {
            $input['start_date'] = Carbon::createFromFormat('Y-m-d H:i', $input['start_date'].' '. $input['start_time']);
            $input['end_date'] = Carbon::createFromFormat('Y-m-d H:i', $input['end_date'].' '. $input['end_time']);
        }

        if(isset($promotion)) {
            $promotion->update($input);
        }

        return redirect()->route('business.admin.promotions', ['bzname' => $bzname])->with('success', 'Promotion updated successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($bzname, $id)
    {
        $user = Auth::guard('business')->user();
        $promotion = PromotionSetting::find($id);
        $image = BusinessPromotion::find($promotion->promotion_id);

        $data = [
            'promotion' => $promotion,
            'image' => $image,
            'bzname' => $bzname,
            'user' => $user,
        ];

        return view('pages.business_admin.promotions.show-promotion', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($bzname, $id)
    {
        $promotion = PromotionSetting::findOrFail($id);

        if (isset($promotion)) {
            $promotion->save();
            $promotion->delete();

            return redirect()->route('business.admin.promotions', ['bzname' => $bzname])->with('success', 'Promotion Deleted Successfully !');
        }

        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }
}
