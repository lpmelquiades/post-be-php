# post-be-php

# TO-DO

1. Paginated Query of Posts, Reposts and Quotes with filters for authoring "All/ ONly Mine". With optional start-date and end-date fields.

1. 1. The homepage, by default, will show a feed of posts (including reposts and quote posts), starting with the latest 10 posts. Older posts are loaded on-demand on chunks of 10 posts whenever the user scrolling reaches the bottom of the page.
1. 2. There is a toggle switch "All / Only mine" that allows you to switch between seeing all posts and just posts you wrote. For both views, all kinds of posts are expected on the feed (original posts, reposts, and quote posts).
1. 3. There is a date range filter option (start date and end date) that allows results filtering based on the posted date, both values are optional: e.g user may want to filter only posts after a certain date without defining a limit date.
1. 4. Shows a feed of the posts the user has made (including reposts and quote posts), starting with the latest 5 posts. Older posts are loaded on-demand when the user clicks on a button at the bottom of the page labeled "show more".

2. Post Aggregate

2. 1. New posts can be written from this page.
2. 2. New posts can be written from this page: for this assessment, when writing a post from the profile screen, the profile user should be set as the author of the new content.
2. 3. Posts are the equivalent of Twitter's tweets. They are text-only, user-generated content. Users can write original posts and interact with other users' posts by reposting or quote-posting. For this project, you should implement all three — original posts, reposts, and quote-posting
2. 4. A user is not allowed to post more than 5 posts in one day (including reposts and quote posts)
2. 5. Users cannot update or delete their posts

3. Post Command
3. 1. Posts can have a maximum of 777 characters

4. Repost Command
- Reposting: Users can repost other users' posts (like Twitter Retweet), limited to original posts and quote posts (not reposts)

5. Quote Command
- Quote-post: Users can repost other user's posts and leave a comment along with it (like Twitter Quote Tweet) limited to original and reposts (not quote-posts)

6. User data Query
6. 1. Shows data about the user:
    - Username
    - Date joined Posterr, formatted as such: "March 25, 2021"
    - Count of number of posts the user has made (including reposts and quote posts)

6. 2. Only alphanumeric characters can be used for username
    - Maximum 14 characters for username
    - Usernames should be unique values

7. No CRUD for Users
- Do not build authentication
- Do not build CRUD for users (registration and sign-in will be handled by a different service, the user model should be part of your data modeling tho. You can seed the database with 4 users to help the reviewer demo your solution)
- When/if necessary to make your application function, you may hard-code the user. For example, you may need to do this to implement creating new posts.
