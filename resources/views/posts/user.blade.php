<x-blog-layout meta-title="User Posts" meta-description="Posts del usuario">
    <x-posts-list :metaTitle="'User Posts'" :posts="$posts" :showUserPostsButton="false" :orderBy="$orderBy" :orderDirection="$orderDirection"/>
</x-blog-layout>
