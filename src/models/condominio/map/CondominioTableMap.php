<?php



/**
 * This class defines the structure of the 'condominio' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.condominio.map
 */
class CondominioTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'condominio.map.CondominioTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('condominio');
        $this->setPhpName('Condominio');
        $this->setClassname('Condominio');
        $this->setPackage('condominio');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('condominio_co_condominio_seq');
        // columns
        $this->addPrimaryKey('co_condominio', 'CoCondominio', 'BIGINT', true, null, null);
        $this->addColumn('no_condominio', 'NoCondominio', 'VARCHAR', true, 250, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // CondominioTableMap
