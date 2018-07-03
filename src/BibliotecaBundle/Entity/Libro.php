<?php

namespace BibliotecaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Libro
 *
 * @ORM\Table(name="libro")
 * @ORM\Entity(repositoryClass="BibliotecaBundle\Repository\LibroRepository")
 */
class Libro
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=255)
     */
    private $isbn;

    /**
     * @var string
     *
     * @ORM\Column(name="edicion", type="string", length=255)
     */
    private $edicion;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="text")
     */
    private $foto;

    /**
     * @var string
     *
     * @ORM\Column(name="editorial", type="string", length=255)
     */
    private $editorial;

   /**
    * @ORM\ManyToOne(targetEntity="Idioma")
    * @ORM\JoinColumn(name="idioma_id", referencedColumnName="id")
    **/
    private $idioma;

   /**
    * @ORM\ManyToMany(targetEntity="Categoria")
    * @ORM\JoinTable(name="libros_categorias",
    *      joinColumns={@ORM\JoinColumn(name="libro_id", referencedColumnName="id")},
    *      inverseJoinColumns={@ORM\JoinColumn(name="categoria_id", referencedColumnName="id")}
    *      )
    **/
    protected $categorias;

    /**
     * @ORM\ManyToMany(targetEntity="Autor")
     * @ORM\JoinTable(name="libros_autores",
     *      joinColumns={@ORM\JoinColumn(name="libro_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="autor_id", referencedColumnName="id")}
     *      )
     **/
   protected $autores;

   /**
    * Default constructor, initializes collections
    */
   public function __construct()
   {
     $this->categorias = new \Doctrine\Common\Collections\ArrayCollection();
     $this->autores = new \Doctrine\Common\Collections\ArrayCollection();
     $this->idiomas = new \Doctrine\Common\Collections\ArrayCollection();
   }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Libro
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return Libro
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * Set edicion
     *
     * @param string $edicion
     *
     * @return Libro
     */
    public function setEdicion($edicion)
    {
        $this->edicion = $edicion;

        return $this;
    }

    /**
     * Get edicion
     *
     * @return string
     */
    public function getEdicion()
    {
        return $this->edicion;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Libro
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set editorial
     *
     * @param string $editorial
     *
     * @return Libro
     */
    public function setEditorial($editorial)
    {
        $this->editorial = $editorial;

        return $this;
    }

    /**
     * Get editorial
     *
     * @return string
     */
    public function getEditorial()
    {
        return $this->editorial;
    }

    /**
     * Add categoria
     *
     * @param \BibliotecaBundle\Entity\Categoria $categoria
     *
     * @return Libro
     */
    public function addCategoria(\BibliotecaBundle\Entity\Categoria $categoria)
    {
        $this->categorias[] = $categoria;

        return $this;
    }

    /**
     * Remove categoria
     *
     * @param \BibliotecaBundle\Entity\Categoria $categoria
     */
    public function removeCategoria(\BibliotecaBundle\Entity\Categoria $categoria)
    {
        $this->categorias->removeElement($categoria);
    }

    /**
     * Get categorias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorias()
    {
        return $this->categorias;
    }

    /**
     * Add autore
     *
     * @param \BibliotecaBundle\Entity\Autor $autore
     *
     * @return Libro
     */
    public function addAutore(\BibliotecaBundle\Entity\Autor $autore)
    {
        $this->autores[] = $autore;

        return $this;
    }

    /**
     * Remove autore
     *
     * @param \BibliotecaBundle\Entity\Autor $autore
     */
    public function removeAutore(\BibliotecaBundle\Entity\Autor $autore)
    {
        $this->autores->removeElement($autore);
    }

    /**
     * Get autores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAutores()
    {
        return $this->autores;
    }



    /**
     * Add idioma
     *
     * @param \BibliotecaBundle\Entity\Idioma $idioma
     *
     * @return Libro
     */
    public function addIdioma(\BibliotecaBundle\Entity\Idioma $idioma)
    {
        $this->idiomas[] = $idioma;

        return $this;
    }

    /**
     * Remove idioma
     *
     * @param \BibliotecaBundle\Entity\Idioma $idioma
     */
    public function removeIdioma(\BibliotecaBundle\Entity\Idioma $idioma)
    {
        $this->idiomas->removeElement($idioma);
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Libro
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set idioma
     *
     * @param \BibliotecaBundle\Entity\Idioma $idioma
     *
     * @return Libro
     */
    public function setIdioma(\BibliotecaBundle\Entity\Idioma $idioma = null)
    {
        $this->idioma = $idioma;

        return $this;
    }

    /**
     * Get idioma
     *
     * @return \BibliotecaBundle\Entity\Idioma
     */
    public function getIdioma()
    {
        return $this->idioma;
    }
}
