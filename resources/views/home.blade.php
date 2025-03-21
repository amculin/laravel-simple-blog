<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-10 sm:px-6 lg:px-8">

            {{-- for authenticated users --}}
            @auth
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="space-y-6 p-6">
                    <h2 class="text-lg font-semibold">Your Posts</h2>
                    @foreach ($articles as $post)
                    <div class="rounded-md border p-5 shadow">
                        <div class="flex items-center gap-2">
                            @php
                            $isActive = $post->status == $post::IS_ACTIVE;
                            $isScheduled = $post->status == $post::IS_SCHEDULED;
                            $isDraft = $post->status == $post::IS_DRAFT;

                            if ($isActive) {
                                $background = 'bg-green-100';
                                $color = 'text-green-800';
                            } else if ($isScheduled) {
                                $background = 'bg-gray-100';
                                $color = 'text-gray-800';
                            } else {
                                $background = 'bg-yellow-100';
                                $color = 'text-yellow-800';
                            }
                            @endphp
                            <span @class([
                                'flex-none',
                                'rounded',
                                $background,
                                'px-2',
                                'py-1',
                                $color

                            ])>{{ $post->statusName }}</span>
                            <h3><a href="{{ route('posts.show', $post) }}" class="text-blue-500">{{ $post->title }}</a></h3>
                        </div>
                        <div class="mt-4 flex items-end justify-between">
                            <div>
                                <div>Published: {{ $post->publish_at }}</div>
                                <div>Updated: {{ $post->updated_at }}</div>
                            </div>
                            <div>
                                <a href="{{ route('posts.show', $post) }}" class="text-blue-500">Detail</a> /
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-500">Edit</a> /
                                <form action="{{ route('posts.delete', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-500" type="submit"
                                        onClick="return confirm('Are you sure you want to delete this article?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div>{{ $articles->links() }}</div>
                </div>
            </div>
            @endauth

            @guest
            {{-- for guest users --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>Please <a href="{{ route('login') }}" class="text-blue-500">login</a> or
                    <a href="{{ route('register') }}" class="text-blue-500">register</a>.</p>
                </div>
            </div>
            @endguest
        </div>
    </div>
</x-app-layout>
