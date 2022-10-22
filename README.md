## Overview
Assessment: https://onstrider.notion.site/Strider-Web-Back-end-Assessment-3-0-9dc16f041f5e4ac3913146bd7a8467c7

Developer: Lucas Melquiades.

Worked around 4 hours each day. Total of 20 hours.
- 2022 October 15 & 16: Env set up & Post Command Model.
- 2022 October 20: Most in Post Command Model & Api-Db-Integration. 
- 2022 October 21: Most in Post Query Model  & Api-Db-Integration.
- 2022 October 22: User Control, User Api Endpoint, General Review & Documentation.

## Project Choices
Things I try to have in mind when coding a microservice/api.
- Low-Coupling,
- High-Cohesion,
- CQRS,
- Onion-Layers,
- Ports&Adapters-Dependency-Inversion).
- SOLID
- OO-Design-Patterns
- DDD-VO, DDD-AGG

## Homepage
*RQ means requeriment. FT means feature.*

*[RQ-01]* The homepage, by default, will show a feed of posts (including reposts and quote posts), starting with the latest 10 posts. Older posts are loaded on-demand on chunks of 10 posts whenever the user scrolling reaches the bottom of the page.

*[RQ-02]* There is a toggle switch "All / Only mine" that allows you to switch between seeing all posts and just posts you wrote. For both views, all kinds of posts are expected on the feed (original posts, reposts, and quote posts).

*[RQ-03]* There is a date range filter option (start date and end date) that allows results filtering based on the posted date, both values are optional: e.g user may want to filter only posts after a certain date without defining a limit date.

*[RQ-04]* New posts can be written from this page.

*[FT-01]* 
- Endpoints (GET /posts 200) & (GET /posts/count 200).
- Supports *[RQ-01]-[RQ-02]-[RQ-03]*.
- Endpoint (GET /posts 200) solves a search of posts filtered by
users[], begin timestamp, end timestamp, page and pagesize.
- The endpoint (GET /posts 200) does not include the total of pages. The cost of that operation might be high, so there is separeted endpoint for that.
- Endpoint (GET /posts/count 200) solves count of posts filtered by users[], begin timestamp, end timestamp.
- MongoDb-4.0 is being used. It is equivalent to AWS-DocumentDB current supported version.
- Endpoint (GET /posts 200) is querying using aggregate-push-slice pipeline with root push and slice for pagination.
- It seems aggregate-push-slice is more performatic when compared to find-skip-limit. A load test could bring more conclusive data about it. 

*[FT-02]*
- Endpoint (POST /post 201).
- Supports *[RQ-04]*.
- 