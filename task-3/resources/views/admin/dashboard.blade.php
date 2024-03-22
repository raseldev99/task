<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    SN
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                              @forelse($users as $user)
                                  <tr class="bg-white border-b hover:bg-gray-50">
                                      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                          {{$loop->iteration}}
                                      </th>
                                      <td class="px-6 py-4 text-center">
                                          {{$user->name}}
                                      </td>
                                      <td class="px-6 py-4 text-center">
                                          {{$user->email}}
                                      </td>
                                      <td class="px-6 py-4 text-center">
                                        <div class="flex gap-x-1 justify-center">
                                            <form action="{{route('admin.approved',$user->id)}}" method="POST">
                                                @csrf
                                                <button type="submit" class="py-2 px-4 rounded bg-green-500 text-white">Approved</button>
                                            </form>
                                            <form action="{{route('admin.declined',$user->id)}}" method="POST">
                                                @csrf
                                                <button onclick="return confirm('Are you sure you want to decline this user registration')" type="submit" class="py-2 px-4 rounded bg-red-500 text-white">Declined</button>
                                            </form>
                                        </div>
                                      </td>
                                  </tr>
                              @empty
                                  <tr>
                                      <td colspan="4" class="text-center text-lg text-gray-700 font-medium py-3">No user found for approval.</td>
                                  </tr>
                              @endforelse
                            </tbody>
                        </table>
                    </div>
                  <div class="py-5">
                      {{$users->links()}}
                  </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
