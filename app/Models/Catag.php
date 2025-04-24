<?php

namespace App\Models;

// use App\Models\Model;

class Catag extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $name = null,
        protected ?string $description = null,
        protected ?\DateTime $createdAt = null,
    )
    {
        $this->table = 'catags';
    }

    
        /**
         * Get the value of id
         *
         * @return ?int
         */
        public function getId(): ?int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param ?int $id
         *
         * @return self
         */
        public function setId(?int $id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of name
         *
         * @return ?string
         */
        public function getName(): ?string
        {
                return $this->name;
        }

        /**
         * Set the value of name
         *
         * @param ?string $name
         *
         * @return self
         */
        public function setName(?string $name): self
        {
                $this->name = $name;

                return $this;
        }

        /**
         * Get the value of description
         *
         * @return ?string
         */
        public function getDescription(): ?string
        {
                return $this->description;
        }

        /**
         * Set the value of description
         *
         * @param ?string $description
         *
         * @return self
         */
        public function setDescription(?string $description): self
        {
                $this->description = $description;

                return $this;
        }

        /**
         * Get the value of createdAt
         *
         * @return ?\DateTime
         */
        public function getCreatedAt(): ?\DateTime
        {
                return $this->createdAt;
        }

        /**
         * Set the value of createdAt
         *
         * @param ?\DateTime $createdAt
         *
         * @return self
         */
        public function setCreatedAt(?\DateTime $createdAt): self
        {
                $this->createdAt = $createdAt;

                return $this;
        }
}