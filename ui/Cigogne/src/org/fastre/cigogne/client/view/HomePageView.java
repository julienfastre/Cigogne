package org.fastre.cigogne.client.view;

import org.fastre.cigogne.client.activities.HomePageActivity;
import com.google.gwt.core.client.GWT;
import com.google.gwt.dom.client.ButtonElement;
import com.google.gwt.dom.client.Element;
import com.google.gwt.dom.client.InputElement;
import com.google.gwt.dom.client.SpanElement;
import com.google.gwt.event.dom.client.ClickEvent;
import com.google.gwt.uibinder.client.UiBinder;
import com.google.gwt.uibinder.client.UiField;
import com.google.gwt.uibinder.client.UiHandler;
import com.google.gwt.user.client.ui.Button;
import com.google.gwt.user.client.ui.Composite;
import com.google.gwt.user.client.ui.TextBox;
import com.google.gwt.user.client.ui.UIObject;
import com.google.gwt.user.client.ui.Widget;

public class HomePageView extends Composite {

	private static HomePageViewUiBinder uiBinder = GWT
			.create(HomePageViewUiBinder.class);

	interface HomePageViewUiBinder extends UiBinder<Widget, HomePageView> {
	}
	
	interface Presenter {
		
	}
	
	
	private HomePageActivity presenter;

	@UiField TextBox codeInput;
	@UiField Button actionButton;

	public HomePageView() {
		initWidget(uiBinder.createAndBindUi(this));
		
	}

	public void setPresenter(HomePageActivity presenter) {
		this.presenter = presenter;
	}
	
	@UiHandler("actionButton")
	public void onClickActionButton(ClickEvent e) {
		presenter.doSearch(e);
	}
	
	public String getCode() {
		return codeInput.getText();
	}
	
	

}
