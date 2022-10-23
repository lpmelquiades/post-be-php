db = db.getSiblingDB('post_db');

db.createCollection('post');

db.post.createIndex(
    {
        "user_name": 1,
        "ticket_begin": -1,
        "ticket_end": -1,
        "ticket_count": 1
    },
    {
        unique: true
    }
);

db.post.createIndex(
    {
        "id": 1
    },
    {
        unique: true
    }
);

db.post.createIndex(
    {
        "user_name": 1
    },
    {
        unique: false
    }
);

db.post.createIndex(
    {
        "user_name": 1,
        "created_at": -1
    },
    {
        unique: false
    }
);

db.post.createIndex(
    {
        "created_at": -1
    },
    {
        unique: false
    }
);
