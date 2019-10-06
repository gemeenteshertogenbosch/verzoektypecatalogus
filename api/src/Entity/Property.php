<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


use App\Entity\RequestType;

/**
 * This property follows the following shemes (in order of impotance)
 * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/3.0.2.md 
 * https://tools.ietf.org/html/draft-wright-json-schema-validation-00
 * http://json-schema.org/
 * 
 * @ApiResource(
 *     normalizationContext={"groups"={"read"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write"}, "enable_max_depth"=true}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 */
class Property
{
	/**
	 * @var \Ramsey\Uuid\UuidInterface $id The UUID identifier of this object
	 * @example e2984465-190a-4562-829e-a8cca81aa35d
	 *
	 * @ApiProperty(
	 * 	   identifier=true,
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The UUID identifier of this object",
	 *             "type"="string",
	 *             "format"="uuid",
	 *             "example"="e2984465-190a-4562-829e-a8cca81aa35d"
	 *         }
	 *     }
	 * )
	 *
	 * @Assert\Uuid
	 * @ORM\Id
	 * @ORM\Column(type="uuid", unique=true)
	 * @ORM\GeneratedValue(strategy="CUSTOM")
	 * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
	 */
	private $id;

    /**
	 * @var string $requestType The requestType that this property belongs to
	 * 
     * @Assert\NotBlank
     * @ORM\ManyToOne(targetEntity="App\Entity\RequestType", inversedBy="properties",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $requestType;    
    
    /**
	 * @var string $title The title of this property
     * @example My Property
	 *
	 * @ApiProperty(
     * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The title of this property",
	 *             "type"="string",
	 *             "example"="My Property",
	 *             "maxLength"="15",
	 *             "maxLength"="255",
	 *             "required" = true
	 *         }
	 *     }
	 * )
     * @Assert\NotBlank
     * @Assert\Length(min = 15, max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $title;
    
    /**     *
	 * @var string $name The name of the property as used in api calls, extracted from title on snake_case basis
     * @example my_property
	 *
	 * @ApiProperty(
     * 	   iri="http://schema.org/name",
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The name of the property as used in api calls, extracted from title on snake_case basis",
	 *             "type"="string",
	 *             "example"="my_property",
	 *             "maxLength"="15",
	 *             "maxLength"="255",
	 *             "required" = true
	 *         }
	 *     }
	 * )
     * @Groups({"read"})
     */
    private $name;
    
    /**      
	 * @var string $type The name of the property as used in api calls, extracted from title on snake_case basis
     * @example string
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The name of the property as used in api calls, extracted from title on snake_case basis",
	 *             "type"="string",
	 *             "example"="string",
	 *             "enum"={"string", "integer", "boolean", "number","array"},
	 *             "maxLength"="255",
	 *             "required" = true
	 *         }
	 *     }
	 * )
     *
     * @Assert\NotBlank
     * @Assert\Length(max = 255)
     * @Assert\Choice({"string", "integer", "boolean", "number","array"})
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $type;    
    
    /**      
	 * @var string $type The swagger type of the property as used in api calls
     * @example string
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The swagger type of the property as used in api calls",
	 *             "type"="string",
	 *             "example"="string",
	 *             "enum"={"int32","int64","float","double","byte","binary","date","duration","date-time","password","boolean","string","uuid","uri","email","rsin","bag","bsn","iban"},
	 *             "maxLength"="255",
	 *             "required" = true
	 *         }
	 *     }
	 * )
	 *       
     * @Assert\NotBlank
     * @Assert\Length(max = 255)
     * @Assert\Choice({"int32","int64","float","double","byte","binary","date","date-time","duration","password","boolean","string","uuid","uri","email","rsin","bag","bsn","iban"})
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255)
     */
    private $format;

    /**
	 * @var string $multipleOf *Can only be used in combination with type integer* Specifies a number that value should be a multiple of, e.g. a multiple of 2 would validate 2,4 and 6 but would prevent 5 
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type integer* Specifies a number that value should be a multiple of, e.g. a multiple of 2 would validate 2,4 and 6 but would prevent 5",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $multipleOf;

    /**
	 * @var string $multipleOf *Can only be used in combination with type integer* The maximum alowed value 
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type integer* The maximum alowed value",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maximum;

    /**
	 * @var string $exclusiveMaximum *Can only be used in combination with type integer* Defines if the maximum is exlusive, e.g. a exlusive maximum of 5 would invalidate 5 but validate 4
     * @example true
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type integer* Defines if the maximum is exlusive, e.g. a exlusive maximum of 5 would invalidate 5 but validate 4",
	 *             "type"="boolean",
	 *             "example"=true
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $exclusiveMaximum;

    /**
	 * @var string $minimum *Can only be used in combination with type integer* The minimum alowed value 
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type integer* The minimum alowed value",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minimum;

    /**
     * 
	 * @var string $exclusiveMinimum *Can only be used in combination with type integer* Defines if the minimum is exlusive, e.g. a exlusive minimum of 5 would invalidate 5 but validate 6
     * @example true
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type integer* Defines if the minimum is exlusive, e.g. a exlusive minimum of 5 would invalidate 5 but validate 4",
	 *             "type"="boolean",
	 *             "example"=true
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $exclusiveMinimum;

    /**
	 * @var string $maxLength The maximum amount of characters in the value 
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The maximum amount of characters in the value",
	 *             "type"="integer",
	 *             "example"="2"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxLength;

    /**
	 * @var string $minLength The minimal amount of characters in the value
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The minimal amount of characters in the value",
	 *             "type"="integer",
	 *             "example"="2"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minLength;

    /**
	 * @var string $pattern A [regular expresion](https://en.wikipedia.org/wiki/Regular_expression) that the value should comply to
     * @example [+-]?(\d+(\.\d+)?|\.\d+)([eE][+-]?\d+)?
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "A [regular expresion](https://en.wikipedia.org/wiki/Regular_expression) that the value should comply to",
	 *             "type"="string",
	 *             "example"="[+-]?(\d+(\.\d+)?|\.\d+)([eE][+-]?\d+)?",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Length(max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pattern;

    /**
     * Not yet supported by business logic
     * 
     * @ORM\ManyToMany(targetEntity="App\Entity\Property")
     */
    private $items;

    /**
     * Not yet supported by business logic
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $additionalItems;

    /**
	 * @var string $maxItems *Can only be used in combination with type array* The maximum arraylength  
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type array* The minimum array length ",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxItems;

    /**
	 * @var string $minItems *Can only be used in combination with type array* The minimum alowed value 
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type array* The minimum alowed value",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minItems;

    /**
	 * @var boolean $uniqueItems *Can only be used in combination with type array* Define whether or not values in an array should be unique
     * @example false
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type array*  Define whether or not values in an array should be unique",
	 *             "type"="boolean",
	 *             "example"=false
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $uniqueItems;

    /**
	 * @var string $maxProperties *Can only be used in combination with type integer* The minimum alowed value 
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type integer* The minimum alowed value",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxProperties;

    /**
	 * @var string $minProperties *Can only be used in combination with type object* The minimum amount of properties an object should contain
     * @example 2
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*Can only be used in combination with type object* The minimum amount of properties an object should contain",
	 *             "type"="integer",
	 *             "example"="2",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("integer")
     * @Groups({"read", "write"})
     * @ORM\Column(type="integer", nullable=true)
     */
    private $minProperties;

    /**
	 * @var boolean $required Only Whether or not this property is required
     * @example false
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "Whether or not this property is required",
	 *             "type"="boolean",
	 *             "example"=false
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $required;

    /**
     * Not yet supported by business logic
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $properties;

    /**
     * Not yet supported by business logic
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $additionalProperties;

    /**
     * Not yet supported by business logic
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="object", nullable=true)
     */
    private $object;

    /**
	 * @var array $enum An array of posible values, input is limited to this array
     * @example ['first','second]
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An array of posible values, input is limited to this array",
	 *             "type"="array",
	 *             "example"="['first','second]'"
	 *         }
	 *     }
	 * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="array", nullable=true)
     */
    private $enum = [];

    /**
	 * @var array $allOf *mutually exclusive with using type* An array of posible types that an property should confirm to
     * @example ['string','boolean']
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*mutually exclusive with using type* An array of posible types that an property should confirm to",
	 *             "type"="array",
	 *             "example"="['string','boolean']"
	 *         }
	 *     }
	 * )
     * 
     * @ORM\Column(type="array", nullable=true)
     */
    private $allOf = [];

    /**
	 * @var array $anyOf *mutually exclusive with using type* An array of posible types that an property mighy confirm to
     * @example ['string','boolean']
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*mutually exclusive with using type* An array of posible types that an property mighy confirm to",
	 *             "type"="array",
	 *             "example"="['string','boolean']"
	 *         }
	 *     }
	 * )
     * 
     * @ORM\Column(type="array", nullable=true)
     */
    private $anyOf = [];

    /**
	 * @var array $oneOf *mutually exclusive with using type* An array of posible types that an property might confirm to
     * @example ['string','boolean']
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*mutually exclusive with using type* An array of posible types that an property might confirm to",
	 *             "type"="array",
	 *             "example"="['string','boolean']"
	 *         }
	 *     }
	 * )
     * 
     * @ORM\Column(type="array", nullable=true)
     */
    private $oneOf = [];

    /**
     * Not yet supported by business logic
     * 
     * @ORM\Column(type="object", nullable=true)
     */
    private $definitions;

    /**
	 * @var string $description An description of the value asked, supports markdown syntax as described by [CommonMark 0.27.](https://spec.commonmark.org/0.27/)
     * @example My value
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An description of the value asked, supports markdown syntax as described by [CommonMark 0.27.](https://spec.commonmark.org/0.27/)",
	 *             "type"="string",
	 *             "example"="My value",
	 *             "maxLength"="2555"
	 *         }
	 *     }
	 * )
     *      
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
	 * @var string $defaultValue An default value for this value that will be used if a user doesn't supply a value
     * @example My value
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An default value for this value that will be used if a user doesn't supply a value",
	 *             "type"="string",
	 *             "example"="My value",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Length(max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $defaultValue;


    /**
	 * @var boolean $nullable Whether or not this property can be left empty
     * @example false
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "Whether or not this property can be left empty",
	 *             "type"="boolean",
	 *             "example"=false
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $nullable;

    /**
	 * @var string $discriminator To help API consumers detect the object type, you can add the discriminator/propertyName keyword to model definitions. This keyword points to the property that specifies the data type name
     * @example name
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "To help API consumers detect the object type, you can add the discriminator/propertyName keyword to model definitions. This keyword points to the property that specifies the data type name",
	 *             "type"="string",
	 *             "example"="name",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Length(max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $discriminator;

    /**
	 * @var boolean $readOnly Whether or not this property is read only
     * @example false
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "Whether or not this property is read only",
	 *             "type"="boolean",
	 *             "example"=false
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $readOnly;

    /**
	 * @var boolean $writeOnly Whether or not this property is write only
     * @example false
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "Whether or not this property is wite only",
	 *             "type"="boolean",
	 *             "example"=false
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $writeOnly;

    /**
	 * @var string $xml An XML representation of the swaggor docs
     * @example <xml></xml>
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An XML representation of the swaggor docs",
	 *             "type"="string",
	 *             "format"="xml",
	 *             "example"="<xml></xml>",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="text", nullable=true)
     */
    private $xml;

    /**
	 * @var string $externalDoc An link to any external documentation for the value
     * @example https://www.w3.org/TR/NOTE-datetime
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An link to any external documentation for the value",
	 *             "type"="string",
	 *             "format"="url",
	 *             "example"="https://www.w3.org/TR/NOTE-datetime",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Length(max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $externalDoc;

    /**
	 * @var string $example An example of the value that should be suplied
     * @example My value
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "An example of the value that should be suplied",
	 *             "type"="string",
	 *             "example"="My value",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
	 * 
     * @Assert\Length(max = 255)
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $example;

    /**
	 * @var boolean $deprecated Whether or not this property has been deprecated and wil be reomoved in the future
     * @example false
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "Whether or not this property has been deprecated and wil be reomoved in the future",
	 *             "type"="boolean",
	 *             "example"=false
	 *         }
	 *     }
	 * )
     * 
     * @Assert\Type("bool")
     * @Groups({"read", "write"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $deprecated;

    /**
	 * @var string $availableUntil  The moment from wich this value is available
     * @example 2019-09-16T14:26:51+00:00
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The moment from wich this value is available",
	 *             "type"="string",
	 *             "format"="date-time",
	 *             "example"="2019-09-16T14:26:51+00:00"
	 *         }
	 *     }
	 * )
     * 
     * @Groups({"read", "write"})
     * @Assert\DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $availableFrom;

    /**
	 * @var string $availableUntil *should be used in combination with deprecated* The moment where until this value is available
     * @example 2019-09-16T14:26:51+00:00
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "*should be used in combination with deprecated* The moment where until this value is available",
	 *             "type"="string",
	 *             "format"="date-time",
	 *             "example"="2019-09-16T14:26:51+00:00"
	 *         }
	 *     }
	 * )
     * 
     * @Groups({"read", "write"})
     * @Assert\DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $availableUntil;

    /**
	 * @var string $minDate The minimal date for value, either a date, datetime or duration (ISO_8601)
     * @example 2019-09-16T14:26:51+00:00
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The minimal date for value, either a date, datetime or duration (ISO_8601)",
	 *             "type"="string",
	 *             "example"="2019-09-16T14:26:51+00:00",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     *      
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $minDate;

    /**
	 * @var string $maxDate  The maximum date for value, either a date, datetime or duration (ISO_8601)
     * @example 2019-09-16T14:26:51+00:00
	 *
	 * @ApiProperty(
	 *     attributes={
	 *         "swagger_context"={
	 *         	   "description" = "The maximum date for value, either a date, datetime or duration (ISO_8601)",
	 *             "type"="string",
	 *             "example"="2019-09-16T14:26:51+00:00",
	 *             "maxLength"="255"
	 *         }
	 *     }
	 * )
     * 
     * @Groups({"read", "write"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $maxDate;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setId(string $id): self
    {
    	$this->id = $id;
    	
    	return $this;
    }

    public function getRequestType(): ?RequestType
    {
    	return $this->requestType;
    }

    public function setRequestType(?RequestType $requestType): self
    {
    	$this->requestType = $requestType;

        return $this;
    }

    public function getTitle(): ?string
    {
    	return $this->title;
    }

    public function setTitle(string $title): self
    {	   	
        $this->title = $title;

        return $this;
    }
        
    public function getName(): ?string
    {
    	// titles wil be used as trings so lets convert the to camelcase
    	$string =  $this->title;
    	$string = trim($string); //removes whitespace at begin and ending
    	$string = preg_replace('/\s+/', '_', $string); // replaces other whitespaces with _
    	$string = strtolower($string);
    	
    	return $string;
    }

    public function getMultipleOf(): ?int
    {
        return $this->multipleOf;
    }

    public function setMultipleOf(?int $multipleOf): self
    {
        $this->multipleOf = $multipleOf;

        return $this;
    }

    public function getMaximum(): ?int
    {
        return $this->maximum;
    }

    public function setMaximum(?int $maximum): self
    {
        $this->maximum = $maximum;

        return $this;
    }

    public function getExclusiveMaximum(): ?bool
    {
        return $this->exclusiveMaximum;
    }

    public function setExclusiveMaximum(?bool $exclusiveMaximum): self
    {
        $this->exclusiveMaximum = $exclusiveMaximum;

        return $this;
    }

    public function getMinimum(): ?int
    {
        return $this->minimum;
    }

    public function setMinimum(?int $minimum): self
    {
        $this->minimum = $minimum;

        return $this;
    }

    public function getExclusiveMinimum(): ?bool
    {
        return $this->exclusiveMinimum;
    }

    public function setExclusiveMinimum(?bool $exclusiveMinimum): self
    {
        $this->exclusiveMinimum = $exclusiveMinimum;

        return $this;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function setMaxLength(?int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    public function setMinLength(?int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function setPattern(?string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(self $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
        }

        return $this;
    }

    public function removeItem(self $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
        }

        return $this;
    }

    public function getAdditionalItems(): ?bool
    {
        return $this->additionalItems;
    }

    public function setAdditionalItems(?bool $additionalItems): self
    {
        $this->additionalItems = $additionalItems;

        return $this;
    }

    public function getMaxItems(): ?int
    {
        return $this->maxItems;
    }

    public function setMaxItems(?int $maxItems): self
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    public function getMinItems(): ?int
    {
        return $this->minItems;
    }

    public function setMinItems(int $minItems): self
    {
        $this->minItems = $minItems;

        return $this;
    }

    public function getUniqueItems(): ?bool
    {
        return $this->uniqueItems;
    }

    public function setUniqueItems(?bool $uniqueItems): self
    {
        $this->uniqueItems = $uniqueItems;

        return $this;
    }

    public function getMaxProperties(): ?int
    {
        return $this->maxProperties;
    }

    public function setMaxProperties(?int $maxProperties): self
    {
        $this->maxProperties = $maxProperties;

        return $this;
    }

    public function getMinProperties(): ?int
    {
        return $this->minProperties;
    }

    public function setMinProperties(?int $minProperties): self
    {
        $this->minProperties = $minProperties;

        return $this;
    }

    public function getRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(?bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties($properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    public function setAdditionalProperties($additionalProperties): self
    {
        $this->additionalProperties = $additionalProperties;

        return $this;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function setObject($object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getEnum(): ?array
    {
        return $this->enum;
    }

    public function setEnum(?array $enum): self
    {
        $this->enum = $enum;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAllOf(): ?array
    {
        return $this->allOf;
    }

    public function setAllOf(?array $allOf): self
    {
        $this->allOf = $allOf;

        return $this;
    }

    public function getAnyOf(): ?array
    {
        return $this->anyOf;
    }

    public function setAnyOf(?array $anyOf): self
    {
        $this->anyOf = $anyOf;

        return $this;
    }

    public function getOneOf(): ?array
    {
        return $this->oneOf;
    }

    public function setOneOf(?array $oneOf): self
    {
        $this->oneOf = $oneOf;

        return $this;
    }

    public function getDefinitions()
    {
        return $this->definitions;
    }

    public function setDefinitions($definitions): self
    {
        $this->definitions = $definitions;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(?string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getNullable(): ?bool
    {
        return $this->nullable;
    }

    public function setNullable(bool $nullable): self
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function getDiscriminator()
    {
        return $this->discriminator;
    }

    public function setDiscriminator($discriminator): self
    {
        $this->discriminator = $discriminator;

        return $this;
    }

    public function getReadOnly(): ?bool
    {
        return $this->readOnly;
    }

    public function setReadOnly(?bool $readOnly): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    public function getWriteOnly(): ?bool
    {
        return $this->writeOnly;
    }

    public function setWriteOnly(?bool $writeOnly): self
    {
        $this->writeOnly = $writeOnly;

        return $this;
    }

    public function getXml()
    {
        return $this->xml;
    }

    public function setXml($xml): self
    {
        $this->xml = $xml;

        return $this;
    }

    public function getExternalDoc()
    {
        return $this->externalDoc;
    }

    public function setExternalDoc($externalDoc): self
    {
        $this->externalDoc = $externalDoc;

        return $this;
    }

    public function getExample(): ?string
    {
        return $this->example;
    }

    public function setExample(?string $example): self
    {
        $this->example = $example;

        return $this;
    }

    public function getDeprecated(): ?bool
    {
        return $this->deprecated;
    }

    public function setDeprecated(?bool $deprecated): self
    {
        $this->deprecated = $deprecated;

        return $this;
    }

    public function getAvailableFrom(): ?\DateTimeInterface
    {
        return $this->availableFrom;
    }

    public function setAvailableFrom(\DateTimeInterface $availableFrom): self
    {
        $this->availableFrom = $availableFrom;

        return $this;
    }

    public function getAvailableUntil(): ?\DateTimeInterface
    {
        return $this->availableUntil;
    }

    public function setAvailableUntil(?\DateTimeInterface $availableUntil): self
    {
        $this->availableUntil = $availableUntil;

        return $this;
    }

    public function getMinDate(): ?string
    {
        return $this->minDate;
    }

    public function setMinDate(?string $minDate): self
    {
        $this->minDate = $minDate;

        return $this;
    }

    public function getMaxDate(): ?string
    {
        return $this->maxDate;
    }

    public function setMaxDate(?string $maxDate): self
    {
        $this->maxDate = $maxDate;

        return $this;
    }
}
