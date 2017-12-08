<?php

class PostPinning
{
    function getQueryArgs($number, $sort_by, $categories, $tags, $pinned)
    {
        // convert , separated number string (eg. '1,2,3')to in array
        $cats = array();
        $pinned_posts = array();

        foreach (explode(',', $categories) as $each_number) {
            $cats[] = (int)$each_number;
        }
        foreach (explode(',', $pinned) as $each_number) {
            $pinned_posts[] = (int)$each_number;
        }

        $post_ids = $this->getCurrentPostIds($number, $cats, $tags);
        $sorted_post_ids = $this->sortPostIds($post_ids, $pinned_posts);

        return array(
            'post_type' => 'post',
            'posts_per_page' => $number,
            'order' => 'post__in',
            'orderby' => 'post__in',
            'post_status' => 'publish',
            'tag' => $tags,
            'post__in' => $sorted_post_ids,
            'ignore_sticky_posts' => 1);
    }

    function getCurrentPostIds($number, $cats, $tags)
    {
        $query = new WP_Query(array(
            'post_type' => 'post',
            'posts_per_page' => $number,
            'order' => 'post__in',
            'post_status' => 'publish',
            'category__in' => $cats,
            'tag' => $tags,
            'ignore_sticky_posts' => 1
        ));
        $posts = $query->posts;

        $post_ids = array();

        foreach ($posts as $post) {
            $post_ids[] = $post->ID;
        }
        return $post_ids;
    }

    function sortPostIds($post_ids, $pinned_posts)
    {
        $filter_dupes = array_filter($post_ids, function ($var) use ($pinned_posts) {
            return !in_array($var, $pinned_posts);
        });
        return array_merge($pinned_posts, $filter_dupes);
    }
}
