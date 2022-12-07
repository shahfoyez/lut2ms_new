@extends('layouts.dashboardMaster')
@section('title')
    Chats
@endsection
@section('content')
   <!--begin::Content-->
   <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            @include('components.flashMessage')
            @include('components.success')
            @include('components.error')
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                    <!--begin::Contacts-->
                    <div class="card card-flush">
                        <!--begin::Card header-->
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <!--begin::Form-->
                            <form class="w-100 position-relative" autocomplete="off">
                                <!--begin::Icon-->
                                <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                                <span class="svg-icon svg-icon-2 svg-icon-lg-1 svg-icon-gray-500 position-absolute foy-top-40 ms-5 translate-middle-y">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                        <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <!--end::Icon-->
                                <!--begin::Input-->
                                <input type="text" class="form-control form-control-solid px-15" name="search" value="" placeholder="Search by username or email..." />
                                <!--end::Input-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-5" id="kt_chat_contacts_body">
                            <!--begin::List-->
                            <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_chat_contacts_body" data-kt-scroll-offset="0px">
                                @if($chats && $chats->count()>0)
                                    @foreach ($chats as $chat)
                                    <?php
                                        $new= $chat->toJson();
                                    ?>
                                        <!--begin::User-->
                                        <div class="d-flex flex-stack py-4 position-relative">
                                            <!--begin::Details-->
                                            <div class="d-flex align-items-center">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-45px symbol-circle">
                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">{{ substr($chat->name, 0,1); }}</span>
                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-15px w-15px ms-n2 mt-n2"></div>
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Details-->
                                                <div class="ms-5">
                                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary mb-2 stretched-link foy-chat" data-item="{{ $new }}"  >{{ $chat->name }}</a>
                                                    <div class="fw-bold text-muted">{{ $chat->email }}</div>
                                                </div>
                                                <!--end::Details-->
                                            </div>
                                            <!--end::Details-->
                                            <!--begin::Lat seen-->
                                            <div class="d-flex flex-column align-items-end ms-2">
                                                <span class="text-muted fs-7 mb-1">{{ $chat->created_at->diffForHumans() }}</span>
                                                <?php
                                                    $status = $chat->status == 0 ? 1 : '';
                                                ?>
                                                @if ($status)
                                                    <span class="badge badge-sm badge-circle badge-light-success">{{ $status }}</span>
                                                @endif
                                            </div>
                                            <!--end::Lat seen-->
                                        </div>
                                        <!--end::User-->
                                        <!--begin::Separator-->
                                        <div class="separator separator-dashed foy-chat-us"></div>
                                        <!--end::Separator-->
                                    @endforeach
                                @endif

                            </div>
                            <!--end::List-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Contacts-->
                </div>
                <!--end::Sidebar-->
                <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                    <div class="card" id="kt_chat_messenger">
                        <div class="chat-box" id="chat-box">
                            <div class="chat-default text-center pb-10">
                                <img class="chat-default-image"v src="{{ asset('assets/images/illustrations/chat.png') }}">
                                <h3>Welcome to Chat</h3>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->
@endsection
@section('scripts')
    <script>
        $(document).on("click", ".foy-chat", function () {
            var data= $(this).attr('data-item');
            let chat = JSON.parse(data)
            console.log(data);
            document.getElementById("chat-box").innerHTML =
            `<div class="card-header" id="kt_chat_messenger_header">
                <div class="card-title">
                    <div class="d-flex justify-content-center flex-column me-3">
                        <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">${chat.name}</a>
                        <div class="mb-0 lh-1">
                            <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                            <span class="fs-7 fw-bold text-muted">Active</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" id="kt_chat_messenger_body">
                <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_toolbar, #kt_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_chat_messenger_body" data-kt-scroll-offset="-2px">
                    <div class="d-flex justify-content-start mb-10">
                        <div class="d-flex flex-column align-items-start">
                            <div class="d-flex align-items-center mb-2">
                                <div class="symbol symbol-35px symbol-circle">
                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">${chat.name.charAt(0)}</span>
                                </div>
                                <div class="ms-3">
                                    <a href="#" class="fs-5 fw-bolder text-gray-900 text-hover-primary me-1">${chat.name}</a>
                                </div>
                            </div>
                            <div class="p-5 rounded bg-light-info text-dark fw-bold mw-lg-400px text-start" data-kt-element="message-text">${chat.message}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                <form action="/chat/reply" class="form mb-15" method="post" id="">
                    @csrf
                    <textarea name="message" class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Reply (Upcoming)"></textarea>
                    <input name="name" value="${chat.name}"hidden>
                    <input name="email" value="${chat.email}"hidden>
                    <div class="d-flex flex-stack">
                        <div class="d-flex align-items-center me-2">
                            <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                <i class="bi bi-paperclip fs-3"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                <i class="bi bi-upload fs-3"></i>
                            </button>
                        </div>
                        <button class="btn btn-primary" type="submit" data-kt-element="send">Send</button>
                    </div>
                </form>
            </div>`;

        });
    </script>
    <!--begin::Page Custom Javascript(used by this page)-->
    <script src="{{ asset('assets/js/custom/widgets.js') }}"></script>
    <script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/create-app.js') }}"></script>
    <script src="{{ asset('assets/js/custom/modals/upgrade-plan.js') }}"></script>
    <!--end::Page Custom Javascript-->
@endsection




