db = db.getSiblingDB('post_db');

db.createCollection('post');

db.post.createIndex(
    {
        "ticket_begin": 1,
        "ticket_end": 1,
        "ticket_count": 1,
        "user_name": 1
    },
    {
        unique: true
    }
);