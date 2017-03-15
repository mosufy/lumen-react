/**
 * MyTodo
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import MyTodoItems from './MyTodoItems';
import Clearfix from './common/Clearfix';
import MyTodoVisibilityFilters from './MyTodoVisibilityFilters';
import LaddaButton, {SLIDE_RIGHT} from 'react-ladda';

const MyTodo = (props) => {
  return (
    <div className="row">
      <div className="col-lg-12">
        <h4>My ToDos</h4>
        <div className="row">
          <div className="col-lg-6">
            <MyTodoItems items={props.items} toggleCompleted={props.toggleCompleted}
                         visibilityFilter={props.visibilityFilter}/>
          </div>
          <div className="col-lg-6">
            <form>
              <div className="input-group">
                <input type="text" id="todo_name" className="form-control" placeholder="Enter ToDo"/>
                <span className="input-group-btn">
                    <LaddaButton
                      className="btn btn-primary"
                      onClick={props.addTodo}
                      loading={props.loading}
                      data-style={SLIDE_RIGHT}>Add ToDo</LaddaButton>
                  </span>
              </div>
            </form>
          </div>
        </div>
        <Clearfix/>
        <div className="row">
          <div className="col-lg-12">
            <MyTodoVisibilityFilters setVisibilityFilter={props.setVisibilityFilter}
                                     visibilityFilter={props.visibilityFilter}/>
            <Clearfix/>
            <p>&nbsp;</p>
            <button className="btn btn-danger" onClick={props.resetTodo}>Reset My ToDos</button>
          </div>
        </div>
        <Clearfix/>
      </div>
    </div>
  );
};

export default MyTodo;