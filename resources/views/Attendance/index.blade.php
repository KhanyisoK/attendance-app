@extends('layouts.app')

@section('content')
<div class="container">
    @if (session()->has('success'))
            <div class="font-semibold rounded-full bg-green-100 text-green-800">
                {{ session()->get('success') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="font-semibold rounded-full bg-red-100 text-red-800">
                {{ session()->get('error') }}
            </div>
        @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="row">
                <div class="input-field col s3">
                    <p>Number of Attendees <b>{{$attendeesCount}}</b></p>
                </div>
                <div class="input-field col s3">
                    <p>With Instrument <b>{{$instrumentCount}}</b></p>
                </div>
                <div class="input-field col s3">
                    <p>Without Instrument <b>{{$instrumentWithOutCount}}</b></p>
                </div>
                <div class="input-field col s3">
                    <p>Total Registered <b>{{$totalCount}}</b></p>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s8">
                    <form method="POST" action="{{ route('store-import')}}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <!-- File Upload Field -->
                        <div class="row">
                            <div class="input-field col s8">
                                <input name="file" type="file" class="validate">
                                <label for="file">Upload File</label>
                            </div>
                            <div class="input-field col s4">
                                <button id="submit-button" class="btn" style="background-color: rgb(31, 81, 255)">{{ __('Upload') }}</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="input-field col s4">
                    <form action="{{ route('search-attend') }}" method="GET">
                        <div>
                            <input name="search" type="text" class="validate" required>
                            <label for="file">Search By Name or Surname</label>
                            <button type="submit" class="btn" style="background-color: rgb(31, 81, 255)">{{ __('Search') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <div>&nbsp;</div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Band
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Instrument
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Attended
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Color
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Actions</span>
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($attendees as $attend)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $attend->band }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ $attend->status }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ $attend->name_surname }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ $attend->instrument }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ $attend->is_attend }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ $attend->color }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                        <a type="button" class="btn" style="background-color: rgb(31, 81, 255)" data-toggle="tooltip" data-placement="bottom"
                        href="{{ route('attend.edit', $attend->id)}}"
                            title="Edit Attendee"><i class="large material-icons">create</i>
                        </a>

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                        @if ($attend->is_attend == 'YES')
                            <p><i style="background-color: rgb(31, 255, 87)" class="material-icons">check_box</i></p>
                        @else
                            <form method="POST" action="{{ route('attend-update', $attend->id)}}">
                                @method('POST')
                                @csrf
                                <input name="is_attend" type="text" hidden value="YES" class="validate">
                                <button id="submit-button" class="btn" style="background-color: rgb(31, 81, 255)">{{ __('Attend') }}</button>
                            </form>
                        @endif

                </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $attendees->links() }}
        </div>
    </div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script type="text/javascript">
    function confirm_delete_author(obj){
        var r = confirm("Are you sure want to delete this record?");
        if (r == true) {
            let author_id = obj;
            $.get('/delete-author/'+author_id,function(data,status){
                console.log('Status',status);
                if(status=='success'){
                    alert("Deleted Successfully");
                    window.location.reload();
                }
            });
        } else {
            alert('Delete action cancelled');
        }
    }
</script>
  </div>
@endsection
