# Overview
Assessment: https://onstrider.notion.site/Strider-Web-Back-end-Assessment-3-0-9dc16f041f5e4ac3913146bd7a8467c7

Developer: Lucas Melquiades.

Worked around 4 hours each day. Total of 20 hours.
- 2022 October 15 & 16: Env set up & Post Command Model.
- 2022 October 20: Most in Post Command Model & Api-Db-Integration. 
- 2022 October 21: Most in Post Query Model  & Api-Db-Integration.
- 2022 October 22: User Control, User Api Endpoint, General Review & Documentation.

I'm used to code microservices that last. 4 hours is not enough.
The most difficult rule here is related to number of posts per day.
If not well design in the db. It will fail because of concurrent writing.

# Setup
1. Call 'make init' to start all containers and install vendor;
2. Call 'make tests' to run unit tests and code coverage analysis;
3. You can see the test coverage analysis pasting this path at your browser.
file:///home/lpmelquiades/post-be-php/tests/_output/coverage/Post/CommandModel/index.html
4. 

# Requirements Map
**RQ means requeriment**

**PLEASE!!!!** Search the project for RQ-01, RQ-02 to understand where each requirement is being supported.

## Homepage

**[RQ-01]** The homepage, by default, will show a feed of posts (including reposts and quote posts), starting with the latest 10 posts. Older posts are loaded on-demand on chunks of 10 posts whenever the user scrolling reaches the bottom of the page.

**[RQ-02]** There is a toggle switch "All / Only mine" that allows you to switch between seeing all posts and just posts you wrote. For both views, all kinds of posts are expected on the feed (original posts, reposts, and quote posts).

**[RQ-03]** There is a date range filter option (start date and end date) that allows results filtering based on the posted date, both values are optional: e.g user may want to filter only posts after a certain date without defining a limit date.

**[RQ-04]** New posts can be written from this page.

## User profile page

**[RQ-05]** Shows data about the user:
- Username
- Date joined Posterr, formatted as such: "March 25, 2021"
- Count of number of posts the user has made (including reposts and quote posts)

**[RQ-06]** - Shows a feed of the posts the user has made (including reposts and quote posts), starting with the latest 5 posts. Older posts are loaded on-demand when the user clicks on a button at the bottom of the page labeled "show more".

**[RQ-07]** New posts can be written from this page: for this assessment, when writing a post from the profile screen, the profile user should be set as the author of the new content.

## User

**[RQ-08]** User Validation
- Only alphanumeric characters can be used for username
- Maximum 14 characters for username
- Usernames should be unique values

**[RQ-09]** User Control
- Do not build authentication
- Do not build CRUD for users (registration and sign-in will be handled by a different service, the user model should be part of your data modeling tho. You can seed the database with 4 users to help the reviewer demo your solution)
- When/if necessary to make your application function, you may hard-code the user. For example, you may need to do this to implement creating new posts.

## Posts

**[RQ-10]** Posts are the equivalent of Twitter's tweets. They are text-only, user-generated content. Users can write original posts and interact with other users' posts by reposting or quote-posting. For this project, you should implement all three — original posts, reposts, and quote-posting

**[RQ-11]**  A user is not allowed to post more than 5 posts in one day (including reposts and quote posts)

**[RQ-12]** Posts can have a maximum of 777 characters

**[RQ-13]** Post Handling Users cannot update or delete their posts

**[RQ-14]** Post Reposting: Users can repost other users' posts (like Twitter Retweet), limited to original posts and quote posts (not reposts)

**[RQ-15]** Quote-post: Users can repost other user's posts and leave a comment along with it (like Twitter Quote Tweet) limited to original and reposts (not quote-posts)

# Critique