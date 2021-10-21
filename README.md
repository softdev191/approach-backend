
## Approach Dating App API

Setup Docker

* Copy .env.example save it as .env
* Docker build
``docker-compose build ``
* Docker up
``docker-compose up -d ``
* Enter docker container
``docker-compose exec app bash ``
* Inside container
``composer install && php artisan migrate``


## API Documentation

### Status Codes
* `200` - Success
* `400` - Bad Request
* `401` - Authorization failed
* `403` - Access denied
* `404` - Entity not found
* `419` - Token Expired
* `422` - Parameter error
* `500` - Server error

#### Open Endpoints
* [Sign up](docs/register.md) `POST http://approach.aleliepangilinan.xyz/api/register`
* [Sign in](docs/login.md) `POST http://approach.aleliepangilinan.xyz/api/login`
* [Email/Mobile Exist](docs/user_mobile_email_exist.md) `POST http://approach.aleliepangilinan.xyz/api/user/exist`
* [Gender Metas](docs/gender_metas.md) `GET http://approach.aleliepangilinan.xyz/api/gender-metas`
* [Attributes](docs/attributes.md) `GET http://approach.aleliepangilinan.xyz/api/attributes/{type}`
* [Looking For Preferences](docs/preferences_looking_for.md) `GET http://approach.aleliepangilinan.xyz/api/preferences/looking-for`

#### Authenticated Enpoints
* [Users nearby](docs/users_nearby.md) `POST http://approach.aleliepangilinan.xyz/api/user/nearby`
* [Add device](docs/add_device.md) `POST http://approach.aleliepangilinan.xyz/api/add-device`
* [Suggest Meeting Place](docs/stores_nearby.md) `POST http://approach.aleliepangilinan.xyz/api/store/nearby`

* [User Profile](docs/user.md) `GET http://approach.aleliepangilinan.xyz/api/user`
* [User Info by Uuid](docs/get_user.md) `GET http://approach.aleliepangilinan.xyz/api/user/{uuid}`
* [Block User](docs/block_user.md) `POST http://approach.aleliepangilinan.xyz/api/user/block`
* [Update Profile](docs/update_profile.md) `POST http://approach.aleliepangilinan.xyz/api/user/update/profile`

* [Get Preferences](docs/preferences.md) `GET http://approach.aleliepangilinan.xyz/api/user/preferences`
* [Save Preferences](docs/save_preferences.md) `POST http://approach.aleliepangilinan.xyz/api/user/preferences`

##### Nudge
* [Send Nudge](docs/send_nudge.md) `POST http://approach.aleliepangilinan.xyz/api/nudge/send`
* [Incoming Nudges](docs/incoming_nudge.md) `GET http://approach.aleliepangilinan.xyz/api/nudge/incoming`
* [Outgoing Nudges](docs/outgoing_nudge.md) `GET http://approach.aleliepangilinan.xyz/api/nudge/outgoing`
* [Outgoing Nudges](docs/accepted_nudge.md) `GET http://approach.aleliepangilinan.xyz/api/nudge/accepted`
* [Update Nudge Status](docs/update_nudge_status.md) `POST http://approach.aleliepangilinan.xyz/api/nudge/update/status`
* [From user info](docs/get_from_user.md) `GET http://approach.aleliepangilinan.xyz/api/nudge/from-user`

##### Message
* [Send](docs/send_message.md) `POST http://approach.aleliepangilinan.xyz/api/message/send`
* [Retrieve](docs/retrieve_message.md) `GET http://approach.aleliepangilinan.xyz/api/message/retrieve/{page}`
