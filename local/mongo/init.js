db = db.getSiblingDB('post_db');

db.createCollection('post');

db.sailing.createIndex(
  {
      "identity.data_type": 1,
      "identity.provider": 1,
      "identity.data_id": 1
  },
  {
      unique: true
  }
);

db.sailing_event.createIndex(
  {
      "id": 1
  },
  {
      unique: true
  }
);

db.sailing_event.createIndex(
  {
      "identity.data_type": 1,
      "identity.provider": 1,
      "identity.data_id": 1
  },
  {
      unique: false
  }
);
