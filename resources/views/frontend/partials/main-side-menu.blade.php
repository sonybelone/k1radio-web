@php
$type = App\Constants\GlobalConst::SETUP_PAGE;
$menues = DB::table('setup_pages')
        ->where('status', 1)
        ->where('type', Str::slug($type))
        ->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    start main-side-menu
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="main-side-menu">
    <div class="main-side-menu-logo-area">
        <div class="thumb-logo">
            <img src="{{ asset('public/frontend/assets/images/logo/logo.png') }}" alt="logo">
        </div>
        <span class="main-side-menu-cross"><i class="las la-times"></i></span>
    </div>
    <ul class="main-side-menu-list">
            @php
            $current_url = URL::current();
            @endphp
            @foreach ($menues as $item)
                @php
                    $title = json_decode($item->title);
                @endphp
            <li><a href="{{ url($item->url) }}" class="@if ($current_url == url($item->url)) active @endif">
                <div class="main-side-menu-item">
                    <i class="{{ $item->icon }}"></i> {{ __($title->title) }}
                </div>
                <span><i class="las la-angle-right"></i></span>
            </a>
        </li>
        @endforeach
        @auth
        <li>
            <a href="javascript:void(0)" class="logout-btn">
                <div class="main-side-menu-item">
                    <i class="las la-sign-out-alt"></i> {{ __("Logout") }}
                </div>
                <span><i class="las la-angle-right"></i></span>
            </a>
        </li>
        @endauth
    </ul>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End main-side-menu
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@push('script')
    <script>
        $(".logout-btn").click(function(){

            var actionRoute =  "{{ setRoute('user.logout') }}";
            var target      = 1;
            var message     = `{{ __("Are you sure to") }} <strong>{{ __("Logout") }}</strong>?`;

            openAlertModal(actionRoute,target,message,"{{ __('Logout') }}","POST");
            function openAlertModal(URL,target,message,actionBtnText = "{{ __('Remove') }}",method = "DELETE"){
    if(URL == "" || target == "") {
        return false;
    }

    if(message == "") {
        message = "{{ __('Are you sure to delete ?') }}";
    }
    var method = `<input type="hidden" name="_method" value="${method}">`;
    openModalByContent(
        {
            content: `<div class="card modal-alert border-0">
                        <div class="card-body">
                            <form method="POST" action="${URL}">
                                <input type="hidden" name="_token" value="${laravelCsrf()}">
                                ${method}
                                <div class="head mb-3">
                                    ${message}
                                    <input type="hidden" name="target" value="${target}">
                                </div>
                                <div class="foot d-flex align-items-center justify-content-between">
                                    <button type="button" class="modal-close btn--base btn-for-modal">{{ __("Close") }}</button>
                                    <button type="submit" class="alert-submit-btn btn--base btn--danger btn-loading btn-for-modal">${actionBtnText}</button>
                                </div>
                            </form>
                        </div>
                    </div>`,
        },

    );
  }
  function openModalByContent(data = {
    content:"",
    animation: "mfp-move-horizontal",
    size: "medium",
  }) {
    $.magnificPopup.open({
      removalDelay: 500,
      items: {
        src: `<div class="white-popup mfp-with-anim ${data.size ?? "medium"}">${data.content}</div>`, // can be a HTML string, jQuery object, or CSS selector
      },
      callbacks: {
        beforeOpen: function() {
          this.st.mainClass = data.animation ?? "mfp-move-horizontal";
        },
        open: function() {
          var modalCloseBtn = this.contentContainer.find(".modal-close");
          $(modalCloseBtn).click(function() {
            $.magnificPopup.close();
          });
        },
      },
      midClick: true,
    });
  }

  function laravelCsrf() {
    return $("head meta[name=csrf-token]").attr("content");
  }

        });
    </script>
@endpush
