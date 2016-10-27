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
                    <LaddaButton
                      className="btn btn-primary"
                      onClick={this.props.addTodo}
                      loading={this.props.loading}
                      data-style={SLIDE_RIGHT}>Add ToDo</LaddaButton>
                  </span>
                </div>
              </form>
            </div>
          </div>
          <Clearfix/>
          <div className="row">
            <div className="col-lg-12">
              <MyTodoVisibilityFilters setVisibilityFilter={this.props.setVisibilityFilter} visibilityFilter={this.props.visibilityFilter}/>
              <Clearfix/>
              <p>&nbsp;</p>
              <button className="btn btn-danger" onClick={this.props.resetTodo}>Reset My ToDos</button>
            </div>
          </div>
          <Clearfix/>
        </div>
      </div>
    );
  }
}