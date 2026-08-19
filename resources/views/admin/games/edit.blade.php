@extends('admin.layouts.app')

@section('content')

<div style="padding:24px;max-width:900px;margin:auto;">

    <h1 style="color:#fff;margin-bottom:25px;">
        Edit Game
    </h1>

    @if($errors->any())

        <div style="
            background:#7f1d1d;
            color:#fecaca;
            padding:15px;
            border-radius:10px;
            margin-bottom:20px;
        ">

            <ul style="margin:0;padding-left:20px;">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <form
        action="{{ route('admin.games.update',$game) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf
        @method('PUT')

        <div style="
            background:#111827;
            padding:25px;
            border-radius:16px;
        ">

            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Nama Game
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name',$game->name) }}"
                    required
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

            </div>

            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Slug
                </label>

                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug',$game->slug) }}"
                    required
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

            </div>

            <div style="margin-bottom:18px;">

                <label style="color:#cbd5e1;">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="4"
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >{{ old('description',$game->description) }}</textarea>

            </div>

            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:20px;
                margin-bottom:20px;
            ">

                <div>

                    <label style="color:#cbd5e1;">
                        Icon Baru
                    </label>

                    <input
                        type="file"
                        name="icon"
                        accept="image/*"
                        style="
                            width:100%;
                            margin-top:8px;
                            color:#cbd5e1;
                        "
                    >

                    @if($game->icon)

                        <img
                            src="{{ asset('storage/'.$game->icon) }}"
                            style="
                                width:70px;
                                height:70px;
                                object-fit:cover;
                                border-radius:10px;
                                margin-top:10px;
                            "
                        >

                    @endif

                </div>

                <div>

                    <label style="color:#cbd5e1;">
                        Banner Baru
                    </label>

                    <input
                        type="file"
                        name="banner"
                        accept="image/*"
                        style="
                            width:100%;
                            margin-top:8px;
                            color:#cbd5e1;
                        "
                    >

                    @if($game->banner)

                        <img
                            src="{{ asset('storage/'.$game->banner) }}"
                            style="
                                width:180px;
                                height:90px;
                                object-fit:cover;
                                border-radius:10px;
                                margin-top:10px;
                            "
                        >

                    @endif

                </div>

            </div>

            <div style="margin-bottom:25px;">

                <label style="color:#cbd5e1;">
                    Status
                </label>

                <select
                    name="status"
                    style="
                        width:100%;
                        margin-top:7px;
                        padding:12px;
                        background:#1e293b;
                        color:#fff;
                        border:1px solid #334155;
                        border-radius:8px;
                    "
                >

                    <option
                        value="active"
                        @selected($game->status === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected($game->status === 'inactive')
                    >
                        Inactive
                    </option>

                </select>

            </div>

            <button
                type="submit"
                style="
                    background:#2563eb;
                    color:white;
                    border:0;
                    padding:12px 20px;
                    border-radius:8px;
                    cursor:pointer;
                    font-weight:bold;
                "
            >
                Update Game
            </button>

        </div>

    </form>

</div>

@endsection
