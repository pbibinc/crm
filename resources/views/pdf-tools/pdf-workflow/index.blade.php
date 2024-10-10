@extends('admin.admin_master')
@section('admin')
    <style>
        /* Define the grid container */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 20px;
            position: relative;
            /* Ensures the spinner can be centered inside */
            height: 300px;
            /* Define the height for the grid container */
        }

        /* Ensure the cards take full width of the grid item */
        .file-card {
            width: 100%;
        }

        /* Hover effect for cards */
        .file-card:hover {
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }

        /* Center the spinner within its container */
        .spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
            /* Ensure the spinner is centered within full width */
            position: absolute;
            top: 0;
            left: 0;
            transform: translate(0, 0);
            /* Reset transformation since we centered it using Flexbox */
        }

        .spin-icon {
            font-size: 2em;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Adjust Dropzone styling */
        .dropzone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            background: #f9f9f9;
            padding: 30px;
            text-align: center;
        }

        .dz-message {
            font-size: 1.2em;
            color: #6c757d;
        }

        .dz-progress {
            width: 100%;
            height: 6px;
            background-color: #e6e6e6;
            margin-top: 10px;
            position: relative;
        }

        .dz-upload {
            display: block;
            height: 100%;
            background-color: #007bff;
            transition: width 0.3s ease;
            width: 0;
        }

        .dz-error-message {
            color: red;
            font-size: 12px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">

    <div class="page-content pt-6">
        {{-- <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center">
            <div id="select_org" class="d-flex flex-wrap justify-content-evenly gap-4">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('backend/assets/images/group_logo_placeholder.jpg') }}"
                        width="400" height="400" alt="" />
                    <div class="card-body">
                        <h4 class="card-title">PBIBINC</h4>
                        <p class="card-text">Click here to select the organization.</p>
                        <a href="#" class="btn btn-primary waves-effect waves-light">Launch</a>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Dashboard --}}
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-column gap-2">
                            <h4 class="card-title">Manage your workflow (Selected Organization: PBIBINC)</h4>
                            <p class="card-title-desc">You can manage your workflow here.</p>
                        </div>
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#inboxModal">Inbox</button>
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#documentsModal">Documents</button>
                                <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                    data-bs-target="#workflowsModal">Workflows</button>
                            </div>
                        </div>
                    </div>

                    <div id="dashboard" class="d-flex gap-4">
                        <div class="button-items d-flex flex-column">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Send documents to receipients.">
                                Send Documents <i class="ri-arrow-right-line align-middle ms-2"></i>
                            </button>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Create a new template.">
                                Create Template <i class="ri-arrow-right-line align-middle ms-2"></i>
                            </button>
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Manage your workflow by controlling the document flow.">
                                Design Workflow <i class="ri-arrow-right-line align-middle ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <div id="templates" class="mt-4">
                        <h4 class="card-title">Templates</h4>
                        <p class="card-title-desc">View all templates you have access to in this workspace.</p>
                        <div class="d-inline-flex flex-wrap gap-4">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0 font-size-18 mb-1">Template Name</h5>
                                            <p class="text-muted font-size-14">Access: Private</p>
                                            <div>
                                                <div class="d-grid mb-3">
                                                    <button type="button"
                                                        class="btn btn-primary btn-lg waves-effect waves-light">Use this
                                                        template <i
                                                            class="ri-arrow-right-line align-middle ms-2"></i></button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0 font-size-18 mb-1">Template Name</h5>
                                            <p class="text-muted font-size-14">Access: Private</p>
                                            <div>
                                                <div class="d-grid mb-3">
                                                    <button type="button"
                                                        class="btn btn-primary btn-lg waves-effect waves-light">Use this
                                                        template <i
                                                            class="ri-arrow-right-line align-middle ms-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Dashboard --}}


        {{-- Modals --}}
        {{-- Inbox --}}
        <div class="modal fade" id="inboxModal" tabindex="-1" role="dialog" aria-labelledby="inboxModalScrollableTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inboxModalScrollableTitle">View incoming and completed documents</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Content here...
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Documents --}}
        <div class="modal fade" id="documentsModal" tabindex="-1" role="dialog"
            aria-labelledby="documentsModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentsModalScrollableTitle">View all your sent documents in this
                            workspace</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Content here...
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Workflows --}}
        <div class="modal fade" id="workflowsModal" tabindex="-1" role="dialog"
            aria-labelledby="workflowsModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="workflowsModalScrollableTitle">View all workflows you have access to
                            in this workspace</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Content here...
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modals --}}

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script></script>
@endsection
