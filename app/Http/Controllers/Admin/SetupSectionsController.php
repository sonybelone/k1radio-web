<?php

namespace App\Http\Controllers\Admin;

use App\Constants\LanguageConst;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\AnnouncementCategory;
use App\Models\Admin\Announcement;
use App\Models\Admin\Language;
use App\Models\Admin\SiteSections;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Response;

class SetupSectionsController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = Language::get();
    }

    /**
     * Register Sections with their slug
     * @param string $slug
     * @param string $type
     * @return string
     */
    public function section($slug, $type)
    {
        $sections = [
            'banner'    => [
                'view'          => "bannerView",
                'itemStore'     => "bannerItemStore",
                'itemUpdate'    => "bannerItemUpdate",
                'itemDelete'    => "bannerItemDelete",
            ],
            'about'  => [
                'view'          => "aboutView",
                'update'        => "aboutUpdate",
                'itemStore'     => "aboutItemStore",
                'itemUpdate'    => "aboutItemUpdate",
                'itemDelete'    => "aboutItemDelete",
            ],
            'contact'  => [
                'view'          => "contactView",
                'update'        => "contactUpdate",
            ],
            'team'  => [
                'view'      => "teamView",
                'update'    => "teamUpdate",
                'itemStore' => "teamItemStore",
                'itemEdit'  => "teamItemEdit",
                'itemUpdate'    => "teamItemUpdate",
                'itemDelete'    => "teamItemDelete",
                'socialItemDelete' => "teamSocialItemDelete",
            ],
            'video'  => [
                'view'      => "videoView",
                'update'    => "videoUpdate",
                'itemStore'     => "videoItemStore",
                'itemUpdate'    => "videoItemUpdate",
                'itemDelete'    => "videoItemDelete",
            ],
            'gallery'  => [
                'view'      => "galleryView",
                'update'    => "galleryUpdate",
                'itemStore'     => "galleryItemStore",
                'itemUpdate'    => "galleryItemUpdate",
                'itemDelete'    => "galleryItemDelete",
            ],
            'testimonial'  => [
                'view'          => "testimonialView",
                'update'        => "testimonialUpdate",
                'itemStore'     => "testimonialItemStore",
                'itemUpdate'    => "testimonialItemUpdate",
                'itemDelete'    => "testimonialItemDelete",
            ],
            'category'    => [
                'view'      => "categoryView",
            ],
            'announcement-section'    => [
                'view'      => "announcementView",
                'update'    => "announcementUpdate",
            ],
            'footer'  => [
                'view'          => "footerView",
                'update'        => "footerUpdate",
                'itemStore'     => "footerItemStore",
                'itemUpdate'    => "footerItemUpdate",
                'itemDelete'    => "footerItemDelete",
            ],
            'auth'  => [
                'view'          => "authView",
                'update'        => "authUpdate",
            ],
        ];

        if (!array_key_exists($slug, $sections)) abort(404);
        if (!isset($sections[$slug][$type])) abort(404);
        $next_step = $sections[$slug][$type];
        return $next_step;
    }

    /**
     * Method for getting specific step based on incoming request
     * @param string $slug
     * @return method
     */
    public function sectionView($slug)
    {
        $section = $this->section($slug, 'view');
        return $this->$section($slug);
    }

    /**
     * Method for distribute store method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemStore(Request $request, $slug)
    {
        $section = $this->section($slug, 'itemStore');
        return $this->$section($request, $slug);
    }


    /**
     * Method for distribute store method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemEdit(Request $request, $slug, $id)
    {
        $section = $this->section($slug, 'itemEdit');
        return $this->$section($request, $slug, $id);
    }

    /**
     * Method for distribute update method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemUpdate(Request $request, $slug)
    {
        $section = $this->section($slug, 'itemUpdate');
        return $this->$section($request, $slug);
    }

    /**
     * Method for distribute delete method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionItemDelete(Request $request, $slug)
    {
        $section = $this->section($slug, 'itemDelete');
        return $this->$section($request, $slug);
    }

    /**
     * Method for distribute delete method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionSocialItemDelete(Request $request, $slug, $id)
    {
        $section = $this->section($slug, 'socialItemDelete');
        return $this->$section($request, $slug, $id);
    }

    /**
     * Method for distribute update method for any section by using slug
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     * @return method
     */
    public function sectionUpdate(Request $request, $slug)
    {
        $section = $this->section($slug, 'update');
        return $this->$section($request, $slug);
    }
    /**
     * Method for show banner section page
     * @param string $slug
     * @return view
     */
    public function bannerView($slug)
    {
        $page_title = __("Banner Section");
        $section_slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.banner-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }
    /**
     * Method for store banner item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function bannerItemStore(Request $request, $slug)
    {
        $basic_field_name = [
            'title'            => "required|string|max:255",
            'description'      => "required|string|max:500",
            'button_name'      => "required|string|max:255",
            'button_link'      => "required|string|max:255",
        ];

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "banner-add");

        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;


        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item added successfully!')]]);
    }

    /**
     * Method for update banner item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function bannerItemUpdate(Request $request, $slug)
    {

        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'title_edit'         => "required|string|max:255",
            'description_edit'   => "required|string|max:500",
            'button_name_edit'   => "required|string|max:255",
            'button_link_edit'   => "required|string|max:255",
        ];

        $slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $section = SiteSections::getData($slug)->first();

        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "banner-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }
        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item updated successfully!')]]);
    }

    /**
     * Method for delete banner item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function bannerItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item deleted successfully!')]]);
    }

    /**
     * Method for show ABOUT section page
     * @param string $slug
     * @return view
     */
    public function aboutView($slug)
    {
        $page_title =  __("About Section");
        $section_slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.about-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update ABOUT section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function aboutUpdate(Request $request, $slug)
    {

        $basic_field_name = ['title' => "required|string|max:100", 'section_title' => "required|string|max:100", 'description' => "required|string|max:1000", 'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        if ($request->hasFile("image")) {
            $section_data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }
        if ($request->hasFile("element")) {
            $section_data['element']      = $this->imageValidate($request, "element", $section->value->element ?? null);
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section updated successfully!')]]);
    }

    /**
     * Method for store About item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function aboutItemStore(Request $request, $slug)
    {
        $basic_field_name = [
            'item_title'         => "required|string|max:255",
            'item_description'   => "required|string|max:255",
            'item_section_icon'   => "required|string|max:100",
        ];

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "about-add");


        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;


        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item added successfully!')]]);
    }

    /**
     * Method for update about item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function aboutItemUpdate(Request $request, $slug)
    {
        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'item_title_edit'           => "required|string|max:255",
            'item_description_edit'     => "required|string|max:255",
            'item_section_icon_edit'     => "required|string|max:100",

        ];

        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);

        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);


        $language_wise_data = $this->contentValidate($request, $basic_field_name, "about-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item updated successfully!')]]);
    }

    /**
     * Method for delete about item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function aboutItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::ABOUT_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        try {
            unset($section_values['items'][$request->target]);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' =>  [__('Section item deleted successfully!')]]);
    }
    /**
     * Method for getting specific step based on incoming request
     * @param string $slug
     * @return method
     */
    public function contactView($slug)
    {
        $page_title = __("Contact Section");
        $section_slug = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.contact-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update contact section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function contactUpdate(Request $request, $slug)
    {
        $basic_field_name = ['section_title' => "required|string|max:100", 'description' => "required|string|max:255", 'location_title' => "required|string|max:100", 'location' => "required|string|max:100", 'call_title' => "required|string|max:100", 'office_hour' => "required|string|max:100", 'email_title' => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::CONTACT_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section updated successfully!')]]);
    }
    /**
     * Method for show team section page
     * @param string $slug
     * @return view
     */
    public function teamView($slug)
    {
        $page_title = __("Team Section");
        $section_slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.team-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update Team section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function teamUpdate(Request $request, $slug)
    {

        $basic_field_name = ['title' => "required|string|max:100", 'section_title' => "required|string|max:100", 'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item updated successfully!')]]);
    }

    /**
     * Method for store Team item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function teamItemStore(Request $request, $slug)
    {
        if($request->type == "noLang"){
            $request->validate([
                'target'    => "required|string",
            ]);
            $validator = Validator::make($request->all(), [
                'link'            => "required|string|url|max:255",
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with('modal', 'teamItem-add');
            }
            $validated = $validator->validate();
            $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
            $section = SiteSections::getData($slug)->first();
            if (!$section) return back()->with(['error' => [__('Section not found!')]]);
            $section_values = json_decode(json_encode($section->value), true);

            if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
            if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);
            $social_links = $section_values['items'][$request->target]['social_links'];
            if ($request->hasFile("icon_image")) {
                $image = upload_file($request->icon_image, 'site-section');
                $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'site-section');
                delete_file($image['dev_path']);
            }
            $social_links[] = [
                'id' => uniqid(),
                'icon_image' => $upload_image,
                'link' => $validated['link'],
            ];
            $section_values['items'][$request->target]['social_links'] = $social_links;
            $update_data['value']   = $section_values;
        }else{
        $validator = Validator::make($request->all(), [
            'icon_image'        => "required|array",
            'icon_image.*'      => "required",
            'link'              => "required|array",
            'link.*'            => "required|string|url|max:255",
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'teamItem-add');
        }
        $validated = $validator->validate();

        $basic_field_name = [
            'item_name'   => "required|string|max:100",
            'item_designation'   => "required|string|max:100",
        ];

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "teamItem-add");


        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";


        $social_links = [];
        foreach ($validated['icon_image'] as $key => $icon) {

            if ($request->hasFile("icon_image")) {
                $image = upload_file($icon, 'site-section');
                $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'site-section');
                delete_file($image['dev_path']);
            }
            $social_links[] = [
                'id'            => uniqid(),
                'icon_image'    => $upload_image,
                'link'          => $validated['link'][$key] ?? "",
            ];
        }
        $section_data['items'][$unique_id]['social_links']    = $social_links;

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;
    }
        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item added successfully!')]]);
    }

    /**
     * team item edit method
     */
    public function teamItemEdit(Request $request, $slug, $id)
    {
        $page_title = __("Team Item Edit");
        $section_slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $data = SiteSections::getData($section_slug)->first();

        $languages = $this->languages;

        return view('admin.sections.setup-sections.edit-team-item', compact(
            'page_title',
            'languages',
            'slug',
            'id',
            'data'
        ));
    }

    /**
     * Method for update Team item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function teamItemUpdate(Request $request, $slug)
    {

        if ($request->type == "lang") {
            $request->validate([
                'target'    => "required|string",
            ]);
            $basic_field_name = [
                'item_name_edit' => "required|string|max:100",
                'item_designation_edit' => "required|string|max:100",
            ];
            $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
            $section = SiteSections::getData($slug)->first();
            if (!$section) return back()->with(['error' => [__('Section not found!')]]);
            $section_values = json_decode(json_encode($section->value), true);

            if (!isset($section_values['items'])) return back()->with(['error' => [__('Team item not found!')]]);
            if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Team item is invalid!')]]);

            $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

            $language_wise_data = $this->contentValidate($request, $basic_field_name);
            if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

            $language_wise_data = array_map(function ($language) {
                return replace_array_key($language, "_edit");
            }, $language_wise_data);
            $section_values['items'][$request->target]['language'] = $language_wise_data;
            if ($request->hasFile("image")) {
                $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
            }
        } else {
            $request->validate([
                'target'    => "required|string",
                'target_item' => 'required',
            ]);
            $validator = Validator::make($request->all(), [
                'link_edit'            => "required|string|url|max:255",
            ]);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with('modal', 'teamItem-edit');
            }
            $validated = $validator->validate();
            $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
            $section = SiteSections::getData($slug)->first();
            if (!$section) return back()->with(['error' => [__('Section not found!')]]);
            $section_values = json_decode(json_encode($section->value), true);

            if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
            if (!array_key_exists($request->target_item, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

                $social_links = $section_values['items'][$request->target_item]['social_links'];

                $id_to_check = $request->target;
                $filtered_items = array_filter($social_links, function ($item) use ($id_to_check) {
                    return $item['id'] === $id_to_check;
                });
                if (!empty($filtered_items)) {
                    $filtered_item = reset($filtered_items);
                    if ($request->hasFile("icon_image")) {
                        $image = upload_file($request->icon_image, 'site-section');
                        $upload_image = upload_files_from_path_dynamic([$image['dev_path']], 'site-section');
                        delete_file($image['dev_path']);
                    } else {
                        $upload_image = $filtered_item['icon_image'];
                    }
                    $social_link_updated = [
                        'id'            => $request->target,
                        'icon_image'    => $upload_image,
                        'link'          => $validated['link_edit'] ?? $filtered_item['link'],
                    ];

                    foreach ($social_links as $key => $social_link) {
                        if ($social_link['id'] === $request->target) {
                            $social_links[$key] = $social_link_updated;
                            break;
                        }
                    }
                    $section_values['items'][$request->target_item]['social_links'] = $social_links;

                } else {
                    return back()->with(['error' => [__('Social link item not found!')]]);
                }
        }
        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item updated successfully!')]]);
    }

    /**
     * Method for delete Team item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function teamItemDelete(Request $request, $slug)
    {

        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item deleted successfully!')]]);
    }

     /**
     * Method for delete Team item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function teamSocialItemDelete(Request $request, $slug, $id)
    {
        $request->validate([
            'target' => 'required|string',
        ]);

        $slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $section = SiteSections::getData($slug)->first();

        if (!$section) {
            return back()->with(['error' => [__('Section not found!')]]);
        }

        $section_values = json_decode(json_encode($section->value), true);

        if (!isset($section_values['items'])) {
            return back()->with(['error' => [__('Section item not found!')]]);
        }

        if (!array_key_exists($id, $section_values['items'])) {
            return back()->with(['error' => [__('Section item is invalid!')]]);
        }

        $social_links = &$section_values['items'][$id]['social_links'];

        $id_to_check = $request->target;

        $filtered_items = array_filter($social_links, function ($item) use ($id_to_check) {
            return $item['id'] === $id_to_check;
        });

        if (!empty($filtered_items)) {
            $filtered_item = reset($filtered_items);

            try {
                $social_links = array_values(array_filter($social_links, function ($item) use ($id_to_check) {
                    return $item['id'] !== $id_to_check;
                }));

                $section->update([
                    'value' => $section_values,
                ]);

                $image_link = get_files_path('site-section') . '/' . $filtered_item['icon_image'];
                delete_file($image_link);

            } catch (Exception $e) {
                return back()->with(['error' => [__('Something went wrong! Please try again')]]);
            }
            return back()->with(['success' => [__('Section Social item deleted successfully!')]]);
        }
    }

    /**
     * Method for show video section page
     * @param string $slug
     * @return view
     */
    public function videoView($slug)
    {
        $page_title = __("Video Section");
        $section_slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.video-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update Video section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function videoUpdate(Request $request, $slug)
    {

        $basic_field_name = ['title' => "required|string|max:100", 'section_title' => "required|string|max:100", 'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section updated successfully!')]]);
    }

    /**
     * Method for store Video item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function videoItemStore(Request $request, $slug)
    {
        $basic_field_name = [
            'item_title'   => "required|string|max:100",
            'item_link'   => "required|string|url|max:255",
            'item_description'   => "required|string|max:500",
        ];

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "videoItem-add");


        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";
        $section_data['items'][$unique_id]['created_at'] = now();

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item added successfully!')]]);
    }

    /**
     * Method for update Video item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function videoItemUpdate(Request $request, $slug)
    {
        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'item_title_edit' => "required|string|max:50",
            'item_link_edit' => "required|string|url|max:255",
            'item_description_edit' => "required|string|max:500",

        ];

        $slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);

        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "videoItem-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;
        $section_values['items'][$request->target]['updated_at'] = now();

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' =>  [__('Section item updated successfully!')]]);
    }

    /**
     * Method for delete Video item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function videoItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' =>  [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item deleted successfully!')]]);
    }
    /**
     * Method for getting specific step based on incoming request
     * @param string $slug
     * @return method
     */
    public function galleryView($slug)
    {
        $page_title = __("Gallery Section");
        $section_slug = Str::slug(SiteSectionConst::GALLERY_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;
        return view('admin.sections.setup-sections.gallery-section', compact(
            'page_title',
            'data',
            'slug',
            'languages'
        ));
    }
    /**
     * Method for update gallery section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function galleryUpdate(Request $request, $slug)
    {

        $basic_field_name = ['title' => "required|string|max:100", 'section_title' => "required|string|max:100", 'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::GALLERY_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' =>  [__('Section updated successfully!')]]);
    }

    /**
     * Method for store gallery item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function galleryItemStore(Request $request, $slug)
    {

        $slug = Str::slug(SiteSectionConst::GALLERY_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";

        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;


        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item added successfully!')]]);
    }

    /**
     * Method for update gallery item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function galleryItemUpdate(Request $request, $slug)
    {

        $request->validate([
            'target'    => "required|string",
        ]);

        $slug = Str::slug(SiteSectionConst::GALLERY_SECTION);
        $section = SiteSections::getData($slug)->first();

        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }
        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' =>  [__('Section item updated successfully!')]]);
    }

    /**
     * Method for delete gallery item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function galleryItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::GALLERY_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);
        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item deleted successfully!')]]);
    }
    /**
     * Method for show testimonial section page
     * @param string $slug
     * @return view
     */
    public function testimonialView($slug)
    {
        $page_title = __("Testimonial Section");
        $section_slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.testimonial-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update testimonial section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function testimonialUpdate(Request $request, $slug)
    {

        $basic_field_name = ['title' => "required|string|max:100", 'section_title' => "required|string|max:100", 'description' => "required|string|max:255", 'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section updated successfully!')]]);
    }

    /**
     * Method for store testimonial item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function testimonialItemStore(Request $request, $slug)
    {
        $basic_field_name = [
            'item_title'         => "required|string|max:255",
            'item_description'   => "required|string|max:255",
            'item_name'          => "required|string|max:255",
            'item_designation'   => "required|string|max:100",
            'item_rating'        => "required|numeric|lte:5",
        ];

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "testimonial-add");


        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;
        $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();

        $section_data['items'][$unique_id]['language'] = $language_wise_data;
        $section_data['items'][$unique_id]['id'] = $unique_id;
        $section_data['items'][$unique_id]['image'] = "";
        if ($request->hasFile("image")) {
            $section_data['items'][$unique_id]['image'] = $this->imageValidate($request, "image", $section->value->items->image ?? null);
        }

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;


        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' =>  [__('Section item added successfully!')]]);
    }

    /**
     * Method for update testimonial item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function testimonialItemUpdate(Request $request, $slug)
    {

        $request->validate([
            'target'    => "required|string",
        ]);

        $basic_field_name = [
            'item_title_edit'         => "required|string|max:255",
            'item_name_edit'          => "required|string|max:255",
            'item_designation_edit'  => "required|string|max:100",
            'item_description_edit'   => "required|string|max:255",
            'item_rating_edit'        => "required|numeric|lte:5",

        ];

        $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);

        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        $request->merge(['old_image' => $section_values['items'][$request->target]['image'] ?? null]);

        $language_wise_data = $this->contentValidate($request, $basic_field_name, "testimonial-edit");
        if ($language_wise_data instanceof RedirectResponse) return $language_wise_data;

        $language_wise_data = array_map(function ($language) {
            return replace_array_key($language, "_edit");
        }, $language_wise_data);

        $section_values['items'][$request->target]['language'] = $language_wise_data;

        if ($request->hasFile("image")) {
            $section_values['items'][$request->target]['image']    = $this->imageValidate($request, "image", $section_values['items'][$request->target]['image'] ?? null);
        }

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item updated successfully!')]]);
    }

    /**
     * Method for delete testimonial item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function testimonialItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::TESTIMONIAL_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' =>  [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);

        try {
            $image_link = get_files_path('site-section') . '/' . $section_values['items'][$request->target]['image'];
            unset($section_values['items'][$request->target]);
            delete_file($image_link);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item deleted successfully!')]]);
    }
    /**
     * Method for show category section page
     * @param string $slug
     * @return view
     */
    public function categoryView()
    {
        $page_title = __("Setup Announcement Category");
        $allCategory = AnnouncementCategory::orderByDesc('id')->paginate(10);
        return view('admin.sections.setup-sections.announcement-category', compact(
            'page_title',
            'allCategory',
        ));
    }
    public function storeCategory(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:200|unique:announcement_categories,name',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'category-add');
        }
        $validated = $validator->validate();
        $slugData = Str::slug($request->name);
        $makeUnique = AnnouncementCategory::where('slug',  $slugData)->first();
        if ($makeUnique) {
            return back()->with(['error' => [$request->name . ' ' . __('Category Already Exists!')]]);
        }
        $admin = Auth::user();

        $validated['admin_id']      = $admin->id;
        $validated['name']          = $request->name;
        $validated['slug']          = $slugData;
        try {
            AnnouncementCategory::create($validated);
            return back()->with(['success' => [__('Category Saved Successfully!')]]);
        } catch (Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again')]]);
        }
    }
    public function categoryUpdate(Request $request)
    {
        $target = $request->target;
        $category = AnnouncementCategory::where('id', $target)->first();
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:200',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'edit-category');
        }
        $validated = $validator->validate();

        $slugData = Str::slug($request->name);
        $makeUnique = AnnouncementCategory::where('id', "!=", $category->id)->where('slug',  $slugData)->first();
        if ($makeUnique) {
            return back()->with(['error' => [$request->name . ' ' . __('Category Already Exists!')]]);
        }
        $admin = Auth::user();
        $validated['admin_id']      = $admin->id;
        $validated['name']          = $request->name;
        $validated['slug']          = $slugData;

        try {
            $category->fill($validated)->save();
            return back()->with(['success' => [__('Category Updated Successfully!')]]);
        } catch (Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again')]]);
        }
    }
    public function categoryStatusUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error, null, 400);
        }
        $validated = $validator->safe()->all();
        $category_id = $validated['data_target'];

        $category = AnnouncementCategory::where('id', $category_id)->first();
        if (!$category) {
            $error = ['error' => [__('Category record not found in our system.')]];
            return Response::error($error, null, 404);
        }

        try {
            $category->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        } catch (Exception $e) {
            $error = ['error' => [__('Something went wrong!. Please try again.')]];
            return Response::error($error, null, 500);
        }

        $success = ['success' => [__('Category status updated successfully!')]];
        return Response::success($success, null, 200);
    }
    public function categoryDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'target'        => 'required|string|exists:announcement_categories,id',
        ]);
        $validated = $validator->validate();
        $category = AnnouncementCategory::where("id", $validated['target'])->first();

        try {
            $category->delete();
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Category deleted successfully!')]]);
    }
    public function categorySearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text'  => 'required|string',
        ]);

        if ($validator->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error, null, 400);
        }

        $validated = $validator->validate();

        $allCategory = AnnouncementCategory::search($validated['text'])->select()->limit(10)->get();
        return view('admin.components.search.category-search', compact(
            'allCategory',
        ));
    }
    public function announcementView($slug)
    {
        $page_title = __("Announcement Section");
        $section_slug = Str::slug(SiteSectionConst::ANNOUNCEMENT_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;
        $categories = AnnouncementCategory::where('status', 1)->latest()->get();
        $announcements = Announcement::latest()->paginate(10);

        return view('admin.sections.setup-sections.announcement-section', compact(
            'page_title',
            'data',
            'languages',
            'slug',
            'categories',
            'announcements'
        ));
    }
    public function announcementUpdate(Request $request, $slug)
    {
        $basic_field_name = ['section_title' => "required|string|max:100", 'title' => "required|string|max:100", 'description' => "required|string|max:255", 'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::ANNOUNCEMENT_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        $data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' =>  [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section updated successfully!')]]);
    }
    public function announcementItemStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'      => 'required|integer',
            'en_name'          => "required|string",
            'en_details'     => "required|string",
            'tags'          => 'nullable|array',
            'tags.*'        => 'nullable|string|max:30',
            'image'         => 'required|image|mimes:png,jpg,jpeg,svg,webp',
        ]);


        $name_filed = [
            'name'     => "required|string",
        ];
        $details_filed = [
            'details'     => "required|string",
        ];

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'announcement-add');
        }
        $validated = $validator->validate();

        // Multiple language data set
        $language_wise_name = $this->contentValidate($request, $name_filed);
        $language_wise_details = $this->contentValidate($request, $details_filed);

        $name_data['language'] = $language_wise_name;
        $details_data['language'] = $language_wise_details;

        $validated['category_id']        = $request->category_id;
        $validated['admin_id']        = Auth::user()->id;
        $validated['name']            = $name_data;
        $validated['details']           = $details_data;
        $validated['slug']            = Str::slug($name_data['language']['en']['name']);
        $validated['tag']           = $request->tags;
        $validated['created_at']      = now();


        // Check Image File is Available or not
        if ($request->hasFile('image')) {
            $image = get_files_from_fileholder($request, 'image');
            $upload = upload_files_from_path_dynamic($image, 'announcement');
            $validated['image'] = $upload;
        }

        try {
            Announcement::create($validated);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Announcement item added successfully!')]]);
    }
    public function announcementEdit($id)
    {
        $page_title = __("Announcement Edit");
        $languages = $this->languages;
        $data = Announcement::findOrFail($id);
        $categories = AnnouncementCategory::where('status', 1)->latest()->get();

        return view('admin.components.modals.site-section.edit-announcement-item', compact(
            'page_title',
            'languages',
            'data',
            'categories',
        ));
    }
    public function announcementItemUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'      => 'required|integer',
            'en_name'     => "required|string",
            'en_details'     => "required|string",
            'tags'          => 'nullable|array',
            'tags.*'        => 'nullable|string|max:30',
            'image'         => 'nullable|image|mimes:png,jpg,jpeg,svg,webp',
            'target'        => 'required|integer',
        ]);


        $name_filed = [
            'name'     => "required|string",
        ];
        $details_filed = [
            'details'     => "required|string",
        ];

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'announcement-edit');
        }

        $validated = $validator->validate();
        $announcement = Announcement::findOrFail($validated['target']);
        // Multiple language data set
        $language_wise_name = $this->contentValidate($request, $name_filed);
        $language_wise_details = $this->contentValidate($request, $details_filed);

        $name_data['language'] = $language_wise_name;
        $details_data['language'] = $language_wise_details;

        $validated['category_id']        = $request->category_id;
        $validated['admin_id']        = Auth::user()->id;
        $validated['name']            = $name_data;
        $validated['details']           = $details_data;
        $validated['slug']            = Str::slug($name_data['language']['en']['name']);
        $validated['tag']           = $request->input('tags', []);
        $validated['created_at']      = now();
        if (!is_array($validated['tag'])) {
            $validated['tag'] = [];
        }
        // Check Image File is Available or not
        if ($request->hasFile('image')) {
            $image = get_files_from_fileholder($request, 'image');
            $upload = upload_files_from_path_dynamic($image, 'announcement', $announcement->image);
            $validated['image'] = $upload;
        }

        try {
            $announcement->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }
        return redirect()->route('admin.setup.sections.section', 'announcement-section')->with(['success' => [__('Announcement item updated successfully!')]]);
    }

    public function announcementItemDelete(Request $request)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);

        $announcement = Announcement::findOrFail($request->target);

        try {
            $image_link = get_files_path('announcement') . '/' . $announcement->image;
            delete_file($image_link);
            $announcement->delete();
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Announcement delete successfully!')]]);
    }
    public function announcementStatusUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error, null, 400);
        }
        $validated = $validator->safe()->all();
        $announcement_id = $validated['data_target'];

        $announcement = Announcement::where('id', $announcement_id)->first();
        if (!$announcement) {
            $error = ['error' => [__('Announcement record not found in our system.')]];
            return Response::error($error, null, 404);
        }

        try {
            $announcement->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        } catch (Exception $e) {
            $error = ['error' => [__('Something went wrong!. Please try again.')]];
            return Response::error($error, null, 500);
        }

        $success = ['success' => [__('Announcement status updated successfully!')]];
        return Response::success($success, null, 200);
    }
    /**
     * Method for show Footer section page
     * @param string $slug
     * @return view
     */
    public function footerView($slug)
    {
        $page_title = __("Footer Section");
        $section_slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $data = SiteSections::getData($section_slug)->first();

        $languages = $this->languages;
        return view('admin.sections.setup-sections.footer-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update Footer section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerUpdate(Request $request, $slug)
    {

        $basic_field_name = ['footer_text' => "required|string|max:100", 'short_description' => "required|string|max:1000", 'location' => 'required|string|max:100', 'mobile' => "required|string|max:100", 'email_address' => "required|string|email|max:100", 'support' => "required|string|email", 'newsletter_title' => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        if ($request->hasFile("image")) {
            $section_data['image']      = $this->imageValidate($request, "image", $section->value->image ?? null);
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Footer updated successfully!')]]);
    }

    /**
     * Method for store footer item
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerItemStore(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'item_name'        => 'required|string|max:100',
            'item_link'        => 'required|string|url|max:100',
            'item_social_icon' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'social-add');
        }
        $validated = $validator->validate();

        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::where("key", $slug)->first();

        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }
        $unique_id = uniqid();
        $section_data['items'][$unique_id] = $validated;
        $section_data['items'][$unique_id]['id'] = $unique_id;

        $update_data['key'] = $slug;
        $update_data['value']   = $section_data;
        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Social icon added successfully!')]]);
    }

    /**
     * Method for update social icon
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerItemUpdate(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'item_name_edit'        => 'required|string|max:100',
            'item_link_edit'        => 'required|string|url|max:100',
            'item_social_icon_edit' => 'required|string|max:100',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'social-edit');
        }
        $validated = $validator->validate();
        $validated = replace_array_key($validated, "_edit");

        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);

        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);



        $section_values['items'][$request->target] = $validated;

        try {
            $section->update([
                'value' => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' =>  [__('Section item deleted successfully!')]]);
    }

    /**
     * Method for delete social icon
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function footerItemDelete(Request $request, $slug)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);
        $slug = Str::slug(SiteSectionConst::FOOTER_SECTION);
        $section = SiteSections::getData($slug)->first();
        if (!$section) return back()->with(['error' => [__('Section not found!')]]);
        $section_values = json_decode(json_encode($section->value), true);
        if (!isset($section_values['items'])) return back()->with(['error' => [__('Section item not found!')]]);
        if (!array_key_exists($request->target, $section_values['items'])) return back()->with(['error' => [__('Section item is invalid!')]]);
        try {
            unset($section_values['items'][$request->target]);
            $section->update([
                'value'     => $section_values,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Section item deleted successfully!')]]);
    }
    /**
     * Method for show auth section page
     * @param string $slug
     * @return view
     */
    public function authView($slug)
    {
        $page_title = __("Auth Section");
        $section_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        $languages = $this->languages;

        return view('admin.sections.setup-sections.auth-section', compact(
            'page_title',
            'data',
            'languages',
            'slug'
        ));
    }

    /**
     * Method for update auth section information
     * @param string $slug
     * @param \Illuminate\Http\Request  $request
     */
    public function authUpdate(Request $request, $slug)
    {
        $basic_field_name = ['login_heading' => "required|string|max:100", 'login_sub_heading' => "required|string|max:255", 'register_heading' => "required|string|max:100", 'register_sub_heading' => "required|string|max:255", 'forgot_heading' => "required|string|max:100", 'forgot_sub_heading' => "required|string|max:255",];

        $slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $section = SiteSections::where("key", $slug)->first();
        if ($section != null) {
            $section_data = json_decode(json_encode($section->value), true);
        } else {
            $section_data = [];
        }

        $section_data['language']  = $this->contentValidate($request, $basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try {
            SiteSections::updateOrCreate(['key' => $slug], $update_data);
        } catch (Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Auth updated successfully!')]]);
    }

    /**
     * Method for get languages form record with little modification for using only this class
     * @return array $languages
     */
    public function languages()
    {
        $languages = Language::whereNot('code', LanguageConst::NOT_REMOVABLE)->select("code", "name")->get()->toArray();
        $languages[] = [
            'name'      => LanguageConst::NOT_REMOVABLE_CODE,
            'code'      => LanguageConst::NOT_REMOVABLE,
        ];
        return $languages;
    }

    /**
     * Method for validate request data and re-decorate language wise data
     * @param object $request
     * @param array $basic_field_name
     * @return array $language_wise_data
     */
    public function contentValidate($request, $basic_field_name, $modal = null)
    {
        $languages = $this->languages();

        $current_local = get_default_language_code();
        $validation_rules = [];
        $language_wise_data = [];
        foreach ($request->all() as $input_name => $input_value) {
            foreach ($languages as $language) {
                $input_name_check = explode("_", $input_name);
                $input_lang_code = array_shift($input_name_check);
                $input_name_check = implode("_", $input_name_check);
                if ($input_lang_code == $language['code']) {
                    if (array_key_exists($input_name_check, $basic_field_name)) {
                        $langCode = $language['code'];
                        if ($current_local == $langCode) {
                            $validation_rules[$input_name] = $basic_field_name[$input_name_check];
                        } else {
                            $validation_rules[$input_name] = str_replace("required", "nullable", $basic_field_name[$input_name_check]);
                        }
                        $language_wise_data[$langCode][$input_name_check] = $input_value;
                    }
                    break;
                }
            }
        }
        if ($modal == null) {
            $validated = Validator::make($request->all(), $validation_rules)->validate();
        } else {
            $validator = Validator::make($request->all(), $validation_rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with("modal", $modal);
            }
            $validated = $validator->validate();
        }

        return $language_wise_data;
    }

    /**
     * Method for validate request image if have
     * @param object $request
     * @param string $input_name
     * @param string $old_image
     * @return boolean|string $upload
     */
    public function imageValidate($request, $input_name, $old_image)
    {
        if ($request->hasFile($input_name)) {
            $image_validated = Validator::make($request->only($input_name), [
                $input_name         => "image|mimes:png,jpg,webp,jpeg,svg",
            ])->validate();

            $image = get_files_from_fileholder($request, $input_name);
            $upload = upload_files_from_path_dynamic($image, 'site-section', $old_image);
            return $upload;
        }

        return false;
    }
}
