<?php
    namespace pdwh {
        class webhook {
            private $identifier;
            private $token;

            private $name;
            private $avatarUrl;

            private $discord_endpoint = "https://discordapp.com/api/webhooks/";

            public function __construct(string $identifier, string $token) {
                $this->identifier = $identifier;
                $this->token = $token;
            }

            public function getURL() {
                return $this->discord_endpoint.$this->identifier."/".$this->token;
            }

            public function getName() {
                return $this->name;
            }

            public function getAvatarUrl() {
                return $this->avatarUrl;
            }

            public function setName(string $name) {
                $this->name = $name;
            }

            public function setAvatarUrl(string $avatarUrl) {
                $this->avatarUrl = $avatarUrl;
            }

            public function defaultName() {
                $this->name = null;
            }

            public function defaultAvatarUrl() {
                $this->avatarUrl = null;
            }


            public function sendMessage(string $message) {
                if(strlen($message) > 2000) {
                    throw new \Exception("Message parameter exceeded 2000 character limit");
                }

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $this->getURL());
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, array(
                    "content" => $message,
                    "username" => $this->name,
                    "avatar_url" => $this->avatarUrl
                ));
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);

                if(curl_error($curl)) {
                    throw new \Exception(curl_error($curl));
                }
                
                return $response;
            }
        }
    }
?>