<?php
/**
 * This is the template for generating a model class file.
 * The following variables are available in this template:
 * - $className: the class name
 * - $tableName: the table name
 * - $columns: a list of table column schema objects
 * - $rules: a list of validation rules (string)
 * - $labels: a list of labels (string)
 * - $relations: a  list of relations (string)
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $className; ?> extends ActiveRecord
{
<?php if (!empty($columns)) { ?>
	/**
	 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
	 * @var <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
	 */
<?php } ?>

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
<?php foreach($labels as $column=>$label): ?>
			<?php echo "'$column' => '$label',\n"; ?>
<?php endforeach; ?>
		);
	}
}