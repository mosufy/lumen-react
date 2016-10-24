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

export default class MyTodo extends React.Component {
  render() {
    return (
      <div className="row">
        <div className="col-lg-12">
          <h4>My ToDos</h4>
          <div className="row">
            <div className="col-lg-6">
              <MyTodoItems items={this.props.items} toggleCompleted={this.props.toggleCompleted} visibilityFilter={this.props.visibilityFilter}/>
            </div>
            <div className="col-lg-6">
              <form>
                <div className="input-group">
                  <input type="text" id="todo_name" className="form-control" placeholder="Enter ToDo"/>
                  <span className="input-group-btn">
                    <button className="btn btn-primary" onClick={this.props.addTodo}>Add ToDo</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
          <Clearfix/>
          <div className="row">
            <div className="col-lg-12">
              <MyTodoVisibilityFilters setVisibilityFilter={this.props.setVisibilityFilter} visibilityFilter={this.props.visibilityFilter}/>
            </div>
          </div>
          <Clearfix/>
        </div>
      </div>
    );
  }
}