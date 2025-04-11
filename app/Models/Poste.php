<?php

namespace App\Models;

// use App\Models\Model;

class Poste extends Model
{
    public function __construct(
        protected ?int $id = null,
        protected ?string $title = null,
        protected ?string $description = null,
        protected ?\DateTime $createdAt = null,
        protected ?bool $enabled = null,
    )
    {
        $this->table = 'postes';
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
         * Get the value of title
         *
         * @return ?string
         */
        public function getTitle(): ?string
        {
                return $this->title;
        }

        /**
         * Set the value of title
         *
         * @param ?string $title
         *
         * @return self
         */
        public function setTitle(?string $title): self
        {
                $this->title = $title;

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

        /**
         * Get the value of enabled
         *
         * @return ?bool
         */
        public function getEnabled(): ?bool
        {
                return $this->enabled;
        }

        /**
         * Set the value of enabled
         *
         * @param ?bool $enabled
         *
         * @return self
         */
        public function setEnabled(?bool $enabled): self
        {
                $this->enabled = $enabled;

                return $this;
        }
}