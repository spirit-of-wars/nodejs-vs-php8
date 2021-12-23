const { DataTypes } = require('sequelize');

const { pageSize } = require('../config/config');

module.exports = (sequelize) => {
  const product = sequelize.define('product', {
    id: {
      allowNull: false,
      autoIncrement: true,
      primaryKey: true,
      type: DataTypes.INTEGER,
    },
    essence_id: {
      type: DataTypes.INTEGER,
    },
    old_modx_id: {
      type: DataTypes.INTEGER,
    },
    id_mif: {
      type: DataTypes.STRING,
    },
    type: {
      type: DataTypes.STRING,
    },
    slug: {
      type: DataTypes.STRING,
    },
    uri: {
      type: DataTypes.STRING,
    },
    price: {
      type: DataTypes.INTEGER,
    },
    life_cycle_status: {
      type: DataTypes.INTEGER,
    },
    release_data: {
      type: DataTypes.TEXT,
    },
    start_sale_date: {
      type: DataTypes.TIME,
    },
    planed_start_sale_date: {
      type: DataTypes.TIME,
    },
    is_dimensionless_for_present: {
      type: DataTypes.BOOLEAN,
    },
    is_available_for_present: {
      type: DataTypes.BOOLEAN,
    },
    created_at: {
      type: DataTypes.TIME,
    },
    updated_at: {
      type: DataTypes.TIME,
    },
  }, {
    timestamps: false,
    tableName: 'product',
  });

  /**
   * Получение количества с кешированием результата в объекте самого метода (this.cachedCount.value)
   * @returns {Promise<*>}
   */
  product.cachedCount = async function () {
    if (this.cachedCount.value === undefined) {
      this.cachedCount.value = await this.count();
    }
    return this.cachedCount.value;
  };

  /**
   * Получение случайной страницы данных
   * @returns {Promise<product[]>}
   */
  product.findRandomPage = async function () {
    // получаем количество товаров
    const count = await this.cachedCount();

    // выбираем одно из возможных смещений
    const offset = Math.floor(count * Math.random() / pageSize) * pageSize;

    // запрос на обновление данных
    const query = `INSERT INTO common.test_insert (offset_number, offset_count) VALUES (${offset}, 1)
      ON CONFLICT (offset_number)
      DO UPDATE SET offset_count = common.test_insert.offset_count + 1;
    `;
    const insertPromise = sequelize.query(query);

    // запрос на получение данных
    const findPromise = this.findAll({
      raw: true,
      limit: pageSize,
      offset,
    });

    // ждем окончания выполнения запроса изменения данных
    await insertPromise;

    // возвращаем результат запроса получения данных
    return await findPromise;
  };
};
