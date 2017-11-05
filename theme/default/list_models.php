<?php
    ML_header();

    class ModelList{
        private $models_;
        private $rowSize_ = 5;

        public function __construct() {
            $this->models_ = ModelDAO::getInstance()->getModels();
        }

        public function renderCell($model) { ?>
        <li>
            <div class="model_cell">
                <div class="model_cell_overlay"></div>
                <div class="model_avatar">
                    <img src="<?php echo $model->getAvatar();?>" alt="">
                </div>
                <div class="model_brief_info">
                    <p class="model_title">
                        <?php echo $model->getName() ?>
                    </p>
                    <p class="model_size">
                        <?php echo $model->getSize() ?>
                    </p>
                    <a class="btn_download" href="action.php?method=download&id=<?php echo $model->getId();?>"></a>
                </div>
                
            </div>
        </li>
       
        <?php
        }

        public function render() {
            $count = 0;
            foreach($this->models_ as $model) {
                $row = $count / $this->rowSize_;
                $col = $count % $this->rowSize_;
                $count++;
                $this->renderCell($model);
            }
        }
    }
  
    function outputModelList() {
        $list = new ModelList();
        $list->render();
    }
?>

<div class="model_list">
    <ul>
        <?php
            outputModelList();
        ?>
    </ul>
</div>

<?php
    ML_footer();
?>