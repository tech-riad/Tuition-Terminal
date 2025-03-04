@extends('layouts.app')

@push('page_css')
<style>
    .report-card {
        padding: 20px;
    }

</style>

@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 ms-sm-auto col-lg-12" style="margin-top: 62px">
            <!-- mini nav starts here -->
            <div class="d-flex flex-wrap mb-4 mb-md-0 justify-content-between align-items-center">
                <div class="d-flex gap-4 flex-column flex-md-row px-3 py-4">
                    <a class="text-decoration-none text-gray-800 active-border" href="index.html">All Notice
                        Dashboard</a>
                    <a class="text-decoration-none text-gray-800 text-nowrap" href="all-popup.html">All Popup Images</a>
                </div>
                <div class="bg-white shadow-lg rounded-3 px-3 py-2 mx-3">
                    <p class="mb-0" id="audience" style="font-weight: 500"></p>
                </div>
            </div>
            <!-- mini nav ends here -->
            <!-- main content section starts here -->
            <!-- submit form starts here -->
            <div class="mx-3 bg-white shadow-lg p-4 rounded-3 mb-4 px-lg-5 py-lg-4">
                <ul class="nav nav-tabs border-0 d-flex gap-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="tab-button active" id="group-tab" data-bs-toggle="tab" data-bs-target="#group"
                            type="button" role="tab" aria-controls="group" aria-selected="true">
                            Group
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="tab-button" id="unit-tab" data-bs-toggle="tab" data-bs-target="#unit"
                            type="button" role="tab" aria-controls="unit" aria-selected="false">
                            Unit
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="home-group">
                        <div class="py-4">
                            <div class="mb-4">
                                <label class="mb-2" style="font-weight: 500">Select Users</label>
                                <select class="form-control rounded-2 shadow-none py-3" id="userType">
                                    <option value="" disabled>Select Users</option>
                                    <option value="tutor" {{ old('userType') == 'tutor' ? 'selected' : '' }}>Tutors</option>
                                    <option value="parent" {{ old('userType') == 'parent' ? 'selected' : '' }}>Parents</option>
                                    <option value="affiliate" {{ old('userType') == 'affiliate' ? 'selected' : '' }}>Affiliate Partners</option>
                                    <option value="employee" {{ old('userType') == 'employee' ? 'selected' : '' }}>Employees</option>
                                    <option value="batch" {{ old('userType') == 'batch' ? 'selected' : '' }}>Batch Tutoring</option>

                                </select>
                            </div>
                            <!-- Tutor Filter model starts here -->
                            <div class="modal fade font-pop" id="filterTutorsModal" tabindex="-1"
                                aria-labelledby="filterTutorsLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-slide-right" style="max-width: 900px">
                                    <div class="modal-content pb-4 pt-3">
                                        <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                                            <h4 class="modal-title" id="exampleModalLabel">Filter Tutors</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body py-0" style="padding-left: 40px">
                                            <div class="row row-cols-1 row-cols-md-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 pe-4">
                                                        <div class="pb-3">
                                                            <label for="datef" class="form-label text-dark text-sm">Date From</label>
                                                            <input type="date" class="form-control shadow rounded-2" id="datef" />
                                                        </div>
                                                        <div class="pb-3">
                                                            <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                                            <input type="date" class="form-control shadow rounded-2" id="datet" />
                                                        </div>
                                                        <div class="pb-3">
                                                            <label for="country" class="form-label text-dark text-sm">Country</label>
                                                            <select class="form-control shadow rounded-2" id="country">
                                                                <option>Bangladesh</option>
                                                                <option>India</option>
                                                                <option>Pakistan</option>
                                                            </select>
                                                        </div>
                                                        <div class="pb-3">
                                                            <label for="city" class="form-label text-dark text-sm">City</label>
                                                            <select class="form-control shadow rounded-2" id="city">
                                                                <option>Dhaka</option>
                                                                <option>Chittagong</option>
                                                                <option>Khulna</option>
                                                            </select>
                                                        </div>
                                                        <div class="pb-3">
                                                            <label for="teachingMethod" class="form-label text-dark text-sm">Teaching Method</label>
                                                            <select class="form-control shadow rounded-2" id="teachingMethod">
                                                                <option>Home Tutoring</option>
                                                                <option>Online Tutoring</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="border-end mt-3" style="height: 200px"></div>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 pe-4">
                                                        <div class="pb-3">
                                                            <label for="gender" class="form-label text-dark text-sm">Gender</label>
                                                            <select class="form-control shadow rounded-2" id="gender">
                                                                <option>Male</option>
                                                                <option>Female</option>
                                                                <option>Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="pb-3">
                                                            <label for="subjects" class="form-label text-dark text-sm">Subjects</label>
                                                            <select class="form-control shadow rounded-2" id="subjects">
                                                                <option>Mathematics</option>
                                                                <option>Physics</option>
                                                                <option>Chemistry</option>
                                                            </select>
                                                        </div>
                                                        <div class="pb-3">
                                                            <label for="category" class="form-label text-dark text-sm">Category</label>
                                                            <select class="form-control shadow rounded-2" id="category">
                                                                <option>SSC</option>
                                                                <option>HSC</option>
                                                                <option>University</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-end align-items-center" style="padding-right: 27px">
                                            <button type="button" class="btn btn-pink" id="clearFilter">Clear</button>
                                            <button type="button" class="btn btn-primary" id="applyFilter">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Tutor Filter Model ends here -->
                            <div class="mb-4">
                                <label class="mb-2" style="font-weight: 500">Select Number</label>
                                <textarea id="selectNumbers" placeholder="Add numbers" class="form-control rounded-2 shadow-none"
                                    style="min-height: 100px"></textarea>
                            </div>
                            <div class="mb-4">
                                <label class="mb-2" style="font-weight: 500">SMS Title</label>
                                <input class="form-control rounded-2 shadow-none py-3"
                                    placeholder="Maximum 30 Character" />
                            </div>
                            <div class="mb-4">
                                <label class="mb-2" style="font-weight: 500">Create SMS Body</label>
                                <textarea placeholder="Maximum 250 Character" class="form-control rounded-2 shadow-none"
                                    style="min-height: 100px"></textarea>
                            </div>
                            <div class="d-flex justify-content-end gap-4">
                                <button class="btn btn-primary">Send</button>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendModal">
                                    Send Later
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Unit --}}

                </div>

            </div>


            <!-- submit form ends here -->
            <!-- table starts here -->
            <div class="ps-3" style="padding-right: 13px">
                <div
                    class="d-flex flex-wrap flex-xl-nowrap justify-content-between flex-column flex-lg-row gap-2 gap-lg-0">
                    <div class="d-flex justify-content-between gap-3 mb-3 mb-xl-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="bi bi-sliders2 me-1"></i>Filter
                        </button>
                        <button class="btn btn-outline-ndark">Send Bulk SMS</button>
                    </div>
                    <div class="d-flex flex-wrap flex-md-nowrap gap-3">
                        <input type="text" class="form-control rounded shadow-none" placeholder="Search" />
                        <select class="form-select rounded shadow-none" style="width: 100px">
                            <option selected value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="200">200</option>
                            <option value="300">300</option>
                            <option value="500">500</option>
                        </select>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-3 p-2 my-4">
                    <div class="bg-white pb-4 mb-b">
                        <div class="table-responsive">
                            <table class="table table-hover bg-white shadow-none" style="border-collapse: collapse">
                                <thead class="text-dark" style="border-bottom: 1px solid #c8ced3">
                                    <tr>
                                        <th scope="col" class="text-nowrap">
                                            <input class="form-check-input me-2" type="checkbox"
                                                id="flexCheckDefault" />#SL
                                        </th>
                                        <th scope="col" class="text-nowrap">Date</th>
                                        <th scope="col" class="text-nowrap">User</th>
                                        <th scope="col" class="text-nowrap">Title</th>
                                        <th scope="col" class="text-nowrap">Audience</th>
                                        <th scope="col" class="text-nowrap">Status</th>
                                        <th scope="col" class="text-nowrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                        <td scope="row" class="text-nowrap">
                                            <input class="form-check-input me-2" type="checkbox"
                                                id="flexCheckDefault" />
                                            001
                                        </td>
                                        <td class="">
                                            <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                06-06-23
                                            </a>
                                        </td>
                                        <td>Tutor</td>
                                        <td class="text-nowrap">
                                            Lorem ipsum dolor sit amet...
                                        </td>
                                        <td class="text-nowrap text-info">912</td>
                                        <td class="text-nowrap text-warning" data-bs-toggle="modal"
                                            data-bs-target="#pendingDateTimeModal" style="cursor: pointer">
                                            Pending
                                        </td>
                                        <td class="">
                                            <div class="d-flex gap-4">
                                                <button class="btn btn-info rounded-3 px-4">
                                                    Edit
                                                </button>
                                                <button class="btn btn-pink rounded-3">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td scope="row" class="text-nowrap">
                                            <input class="form-check-input me-2" type="checkbox"
                                                id="flexCheckDefault" />
                                            002
                                        </td>
                                        <td class="">
                                            <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                06-06-23
                                            </a>
                                        </td>
                                        <td>Tutor</td>
                                        <td class="text-nowrap">
                                            Lorem ipsum dolor sit amet...
                                        </td>
                                        <td class="text-nowrap text-info">455</td>
                                        <td>
                                            <div class="switch-toggle">
                                                <div class="button-check" id="button-check">
                                                    <input type="checkbox" class="checkbox" checked />
                                                    <span class="switch-btn"></span>
                                                    <span class="layer"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="d-flex gap-4">
                                                <button class="btn btn-info rounded-3 px-4">
                                                    Edit
                                                </button>
                                                <button class="btn btn-pink rounded-3">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="align-middle">
                                        <td scope="row" class="text-nowrap">
                                            <input class="form-check-input me-2" type="checkbox"
                                                id="flexCheckDefault" />
                                            003
                                        </td>
                                        <td class="">
                                            <a type="button" class="text-decoration-none text-gray-800 text-nowrap"
                                                data-bs-toggle="modal" data-bs-target="#showDateTimeModal">
                                                06-06-27
                                            </a>
                                        </td>
                                        <td>Tutor</td>
                                        <td class="text-nowrap">
                                            Lorem ipsum dolor sit amet...
                                        </td>
                                        <td class="text-nowrap text-info">681</td>
                                        <td>
                                            <div class="switch-toggle">
                                                <div class="button-check" id="button-check">
                                                    <input type="checkbox" class="checkbox" checked />
                                                    <span class="switch-btn"></span>
                                                    <span class="layer"></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="d-flex gap-4">
                                                <button class="btn btn-info rounded-3 px-4">
                                                    Edit
                                                </button>
                                                <button class="btn btn-pink rounded-3">
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- pagination starts here -->
                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                            <button class="btn btn-outline-gdark py-1 px-2 text-gray-800">
                                <i class="bi bi-chevron-left"></i>
                            </button>
                            <button class="btn btn-outline-gdark py-1 text-gray-800" style="padding: 0 13px">
                                1
                            </button>

                            <button class="btn btn-outline-gdark py-1 text-gray-800" style="padding: 0 13px">
                                2
                            </button>
                            <button class="btn btn-outline-gdark py-1 text-gray-800" style="padding: 0 13px">
                                ..
                            </button>

                            <button class="btn btn-outline-gdark py-1 text-gray-800" style="padding: 0 13px">
                                34
                            </button>

                            <button class="btn btn-outline-gdark py-1 px-2 text-gray-800">
                                <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        <!-- pagination ends here -->
                    </div>
                </div>
            </div>
            <!-- table ends here -->
            <!-- Show Date time model starts here-->
            <div class="modal fade" id="showDateTimeModal" tabindex="-1" aria-labelledby="showDateTimeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body pt-5 pb-4">
                            <p class="text-center text-info fs-3">7 June 2023</p>
                            <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                03:30 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Show Date time model ends here-->
            <!-- Pending Date time model starts here-->
            <div class="modal fade" id="pendingDateTimeModal" tabindex="-1" aria-labelledby="pendingDateTimeModalLabel"
                aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body pt-5 pb-4">
                            <p class="text-center text-warning fs-3">01 Aug 2023</p>
                            <p class="text-center text-gray-700 border-top fs-1 pt-1">
                                03:30 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Pending Date time model ends here-->
            <!-- Send Later model starts here-->
            <div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="sendModalLabel" aria-hidden="true">
                <div class="modal-dialog model-sm modal-dialog-slide-top" style="max-width: 400px">
                    <div class="modal-content">
                        <div class="modal-body">
                            <input type="datetime-local" class="form-control" />
                            <div class="d-flex justify-content-end mt-3">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Send Later model ends here-->
            <!-- Filter model starts here -->
            <div class="modal fade font-pop" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-slide-right" style="max-width: 650px">
                    <div class="modal-content pb-4 pt-3">
                        <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                            <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-0" style="padding-left: 40px">
                            <div class="row row-cols-1 row-cols-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="datef" class="form-label text-dark text-sm">Date from</label>
                                            <div class="">
                                                <input type="date" class="form-control shadow rounded-2" id="datef" />
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                            <input type="date" class="form-control shadow rounded-2" id="datet" />
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="gndr" class="form-label text-dark text-sm">User</label>

                                            <select id="gndr" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="Tutor">Tutor</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                                <option value="Option 4">Option 4</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label for="src" class="form-label text-dark text-sm">Status</label>

                                            <select id="src" class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option selected value="On">On</option>
                                                <option value="Option 1">Option 1</option>
                                                <option value="Option 2">Option 2</option>
                                                <option value="Option 3">Option 3</option>
                                                <option value="Option 4">Option 4</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end align-items-center"
                            style="padding-right: 27px">
                            <div class="pe-2 d-flex gap-3">
                                <button type="button" class="btn btn-pink">Clear</button>
                                <button type="button" class="btn btn-primary">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Filter Model ends here -->
            <!-- Tutor Filter model starts here -->
            <div class="modal fade font-pop" id="filterTutorsModal" tabindex="-1" aria-labelledby="filterTutorsLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-slide-right" style="max-width: 900px">
                    <div class="modal-content pb-4 pt-3">
                        <div class="modal-header" style="padding-left: 40px; padding-right: 40px">
                            <h4 class="modal-title" id="exampleModalLabel">Filter</h4>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body py-0" style="padding-left: 40px">
                            <div class="row row-cols-1 row-cols-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label for="datef" class="form-label text-dark text-sm">Date from</label>
                                            <div class="">
                                                <input type="date" class="form-control shadow rounded-2" id="datef" />
                                            </div>
                                        </div>
                                        <div class="pb-3">
                                            <label for="datet" class="form-label text-dark text-sm">Date To</label>
                                            <input type="date" class="form-control shadow rounded-2" id="datet" />
                                        </div>
                                        <div class="pb-3">
                                            <label for="dactet" class="form-label text-dark text-sm">Country</label>
                                            <select type="date" class="form-control shadow rounded-2" id="dactet">
                                                <option>Bangladesh</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">City</label>
                                            <select type="date" class="form-control shadow rounded-2">
                                                <option>Dhaka</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Location</label>
                                            <select type="date" class="form-control shadow rounded-2" id="dactet">
                                                <option>Mirpur 1</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label text-dark text-sm">Teaching Method</label>
                                            <select type="date" class="form-control shadow rounded-2" id="dactet">
                                                <option>Home Tutoring</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Year</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>2000</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Gender</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Male</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Category</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Course</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Subjects</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="form-label text-dark text-sm">Study Types</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="border-end mt-3" style="height: 125px"></div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 pe-4">
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Curriculam(SSC)</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">University Type</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">University</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Department</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Curriculam(HSC)</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <div class="pb-3">
                                            <label class="form-label text-dark text-sm">Other</label>

                                            <select class="shadow rounded-2 form-select"
                                                aria-label="Default select example">
                                                <option>Other</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end align-items-center"
                            style="padding-right: 27px">
                            <div class="pe-2 d-flex gap-3">
                                <button type="button" class="btn btn-pink">Clear</button>
                                <button type="button" class="btn btn-primary">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tutor Filter Model ends here -->
            <!-- main content section ends here -->
        </div>

    </div>
</div>
@endsection
@push('page_scripts')
@include('backend.job_offers.js.all_offer_page_js')
@include('backend.notice.js.noticejs');

@endpush
