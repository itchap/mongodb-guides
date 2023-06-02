# Simple Game Trigger Example

exports = function(changeEvent) {

  const docId = changeEvent.documentKey._id;
  const fullDocument = changeEvent.fullDocument;
  const updateDescription = changeEvent.updateDescription;

  const mongodb = context.services.get('production');
  const db = mongodb.db('sample_game');
  const collection_mod = db.collection('modified_matches');

  const modifiedDocument = {
    "_id": docId,
    "geo": fullDocument.geoLocale.substring(0, 2),
    "locale": fullDocument.geoLocale.substring(3, fullDocument.geoLocale.length),
    "totalMatchTimeSeconds": fullDocument.totalMatchTimeSeconds,
    "mvpWin": fullDocument.mvpWin,
    "matchDataGained": fullDocument.matchDataGained,
    "playerId": fullDocument.playerId
  };

  collection_mod.insertOne(modifiedDocument)
    .then(result => {console.log(`Successfully inserted item with _id: ${result.insertedId}`); return result})
    .catch(err => {console.error(`Failed to insert item: ${err}`); return err});
};





sudo kubeadm join 192.168.2.214:6443 --token wnq0jq.6ohww9bmy8gm0rhk --discovery-token-ca-cert-hash sha256:ea9914e4dc9c5dbe8d0311b5a90ca0d1b9c11eef5e0cb94b576e9e3d0378ef8e


kubectl create secret generic opsmancredentials \
--from-literal=Username="itchap" \
--from-literal=Password="Nat1_index" \
--from-literal=FirstName="Peter" \
--from-literal=LastName="Smith"

kubectl create secret generic om-db-itchap-secret \
  --from-literal=password="NokiaN900"
