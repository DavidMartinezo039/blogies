<x-blog-layout meta-title="Blog" meta-description="Descripción de la página del Blog">
    <x-posts-list :metaTitle="'Blog'" :categories="$categories" :posts="$posts" :showUserPostsButton="true" :orderBy="$orderBy" :orderDirection="$orderDirection"/>
</x-blog-layout>
