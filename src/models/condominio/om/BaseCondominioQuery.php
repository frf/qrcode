<?php


/**
 * Base class that represents a query for the 'condominio' table.
 *
 *
 *
 * @method CondominioQuery orderByCoCondominio($order = Criteria::ASC) Order by the co_condominio column
 * @method CondominioQuery orderByNoCondominio($order = Criteria::ASC) Order by the no_condominio column
 *
 * @method CondominioQuery groupByCoCondominio() Group by the co_condominio column
 * @method CondominioQuery groupByNoCondominio() Group by the no_condominio column
 *
 * @method CondominioQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CondominioQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CondominioQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Condominio findOne(PropelPDO $con = null) Return the first Condominio matching the query
 * @method Condominio findOneOrCreate(PropelPDO $con = null) Return the first Condominio matching the query, or a new Condominio object populated from the query conditions when no match is found
 *
 * @method Condominio findOneByNoCondominio(string $no_condominio) Return the first Condominio filtered by the no_condominio column
 *
 * @method array findByCoCondominio(string $co_condominio) Return Condominio objects filtered by the co_condominio column
 * @method array findByNoCondominio(string $no_condominio) Return Condominio objects filtered by the no_condominio column
 *
 * @package    propel.generator.condominio.om
 */
abstract class BaseCondominioQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCondominioQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'condominio';
        }
        if (null === $modelName) {
            $modelName = 'Condominio';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CondominioQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CondominioQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CondominioQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CondominioQuery) {
            return $criteria;
        }
        $query = new CondominioQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Condominio|Condominio[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CondominioPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CondominioPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Condominio A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCoCondominio($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Condominio A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT co_condominio, no_condominio FROM condominio WHERE co_condominio = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Condominio();
            $obj->hydrate($row);
            CondominioPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Condominio|Condominio[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Condominio[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CondominioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CondominioPeer::CO_CONDOMINIO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CondominioQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CondominioPeer::CO_CONDOMINIO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the co_condominio column
     *
     * Example usage:
     * <code>
     * $query->filterByCoCondominio(1234); // WHERE co_condominio = 1234
     * $query->filterByCoCondominio(array(12, 34)); // WHERE co_condominio IN (12, 34)
     * $query->filterByCoCondominio(array('min' => 12)); // WHERE co_condominio >= 12
     * $query->filterByCoCondominio(array('max' => 12)); // WHERE co_condominio <= 12
     * </code>
     *
     * @param     mixed $coCondominio The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CondominioQuery The current query, for fluid interface
     */
    public function filterByCoCondominio($coCondominio = null, $comparison = null)
    {
        if (is_array($coCondominio)) {
            $useMinMax = false;
            if (isset($coCondominio['min'])) {
                $this->addUsingAlias(CondominioPeer::CO_CONDOMINIO, $coCondominio['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($coCondominio['max'])) {
                $this->addUsingAlias(CondominioPeer::CO_CONDOMINIO, $coCondominio['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CondominioPeer::CO_CONDOMINIO, $coCondominio, $comparison);
    }

    /**
     * Filter the query on the no_condominio column
     *
     * Example usage:
     * <code>
     * $query->filterByNoCondominio('fooValue');   // WHERE no_condominio = 'fooValue'
     * $query->filterByNoCondominio('%fooValue%'); // WHERE no_condominio LIKE '%fooValue%'
     * </code>
     *
     * @param     string $noCondominio The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CondominioQuery The current query, for fluid interface
     */
    public function filterByNoCondominio($noCondominio = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($noCondominio)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $noCondominio)) {
                $noCondominio = str_replace('*', '%', $noCondominio);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CondominioPeer::NO_CONDOMINIO, $noCondominio, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Condominio $condominio Object to remove from the list of results
     *
     * @return CondominioQuery The current query, for fluid interface
     */
    public function prune($condominio = null)
    {
        if ($condominio) {
            $this->addUsingAlias(CondominioPeer::CO_CONDOMINIO, $condominio->getCoCondominio(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
